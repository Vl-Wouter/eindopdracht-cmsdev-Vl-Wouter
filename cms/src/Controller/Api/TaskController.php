<?php


namespace App\Controller\Api;


use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class TaskController
 * @package App\Controller\Api
 * @Route("/api/tasks", name="api_tasks_")
 */
class TaskController extends AbstractController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {

        $this->taskRepository = $taskRepository;
    }

    /**
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @Route("/{id}", name="index", methods={"GET"})
     */
    public function getTasks($id, SerializerInterface $serializer) {
        $tasks = $this->taskRepository->findByEmployee($id);
        return JsonResponse::fromJsonString($serializer->serialize($tasks, 'json', ['groups' => 'employee']));
    }

    /**
     * @param $id
     * @param Request $r
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Exception
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function updateTask($id, Request $r, SerializerInterface $serializer) {
        $task = $this->taskRepository->find($id);
        $user = $task->getEmployee();
        $company = $task->getPeriod()->getClient();
        $data = json_decode($r->getContent());
        $begin_time = new \DateTime($data->begin_time);
        $end_time = new \DateTime($data->end_time);
        $em = $this->getDoctrine()->getManager();

        // Add data to entity
        $task->setBeginTime($begin_time);
        $task->setEndTime($end_time);
        $task->setBreak($data->break);
        $task->setTransportDistance($data->transport_distance);
        $task->setActivity($data->activity);
        $task->setMaterials($data->materials);

        // Calculate price
        $price = 0;
        $cost = 0;
        $multiplier = 1;
        $over8 = false;
        $t1 = $begin_time->getTimestamp();
        $t2 = $end_time->getTimestamp();
        $hours = (($t2 - $t1) / (60 * 60)) - $data->break;
        // CheckWeekDay
        $dayOfWeek = date("l", $task->getDate()->getTimestamp());

        if($dayOfWeek === "Saturday") {
            $multiplier = 1.5;
        } elseif ($dayOfWeek === "Sunday") {
            $multiplier = 2;
        } else {
            if ($hours > 8) $over8 = true;
        }
        // Set Cost
        $user_rate = $user->getCost();
        $user_transport_rate = $user->getTransport();
        // Set Price
        $client_rate = $company->getCost();
        $client_transport = $company->getTransport();
        if ($over8) {
           $cost = (($user_rate * 8) + (($hours - 8) * $user_rate * 1.2)) + ($data->transport_distance * $user_transport_rate);
           $price = (($client_rate * 8) + (($hours - 8) * $client_rate * 1.2)) + ($data->transport_distance * $client_transport);
        } else {
            $cost = ($user_rate * $hours * $multiplier) + ($data->transport_distance * $user_transport_rate);
            $price = ($client_rate * $hours * $multiplier) + ($data->transport_distance * $client_transport);
        }

        $task->setCost($cost);
        $task->setPrice($price);
        $task->setStatus(true);

        // Save task
        $em->persist($task);
        $em->flush();
        // Return updated task
        return JsonResponse::fromJsonString($serializer->serialize($task, 'json', ["groups"=>"employee"]));
    }

//    public function getUserDetail(User $id, SerializerInterface $serializer) {
//        return JsonResponse::fromJsonString($serializer->serialize($user, 'json'));
//    }
}