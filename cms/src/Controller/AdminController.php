<?php

namespace App\Controller;

use App\Entity\Remark;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
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
     * @Route("", name="index")
     */
    public function index()
    {
        // Init all needed variables
        $totalEarnings = 0;
        $period = 7;
        $bestEmployee = null;
        $allTasks = $this->taskRepository->findAll();
        $tasks_by_day = $this->taskRepository->findAndGroupByDay();
        $remarks = $this->getDoctrine()->getRepository(Remark::class)->findBy([], ['created' => 'desc']);

        $chart_labels = [];
        $chart_data = [];

        foreach ($tasks_by_day as $day) {
            array_push($chart_labels, $day["date"]);
            array_push($chart_data, $day["tasks"]);
        }

        $date = new \DateTime();
        $date_last_period = (new \DateTime())->sub(new \DateInterval("P".$period."D"));
        $date_previous_period = (new \DateTime())->sub(new \DateInterval("P".$period * 2 ."D"));


        $tasks_last_period = $this->taskRepository->findPeriod($date_last_period, $date);
        $tasks_previous_period = $this->taskRepository->findPeriod($date_previous_period, $date_last_period);


        // Calculate earnings
        foreach ($allTasks as $task) {
            $totalEarnings += $task->getPrice();
        }

        // Calculate most earning employee
        $topEmployees = $this->getDoctrine()->getRepository(Task::class)->findTopEmployee();

        return $this->render('admin/index.html.twig', [
            'earnings' => $totalEarnings,
            'completed' => [
                "last_period" => [
                    "tasks" => $tasks_last_period[0]["task_total"],
                    "price" => $tasks_last_period[0]["task_price"],
                ],
                "difference" => [
                    "tasks" => $tasks_last_period[0]["task_total"] - $tasks_previous_period[0]["task_total"],
                    "price" => $tasks_last_period[0]["task_price"] - $tasks_previous_period[0]["task_price"]
                ]
            ],
            'top_employees' => $topEmployees,
            'chart' => [
                "labels" => $chart_labels,
                "data" => $chart_data,
            ],
            'remarks' => $remarks
        ]);
    }
}
