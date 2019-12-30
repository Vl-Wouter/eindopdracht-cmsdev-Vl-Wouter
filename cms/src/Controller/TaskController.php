<?php

namespace App\Controller;

use App\Entity\Period;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Doctrine\Common\Persistence\PersistentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("/admin/tasks", name="tasks_")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAndOrderByStatus();
        $periods = $this->getDoctrine()->getRepository(Period::class)->findAll();
        $alert = null;
        if(!$periods) {
//            $alert = [
//                "type" => "warning",
//                "message" => "Maak een periode aan voordat je een taak toevoegd",
//                "icon" => "ant-design:warning-fill"
//            ];

            $alert = [
                "type" => "error",
                "message" => "Maak een periode aan voordat je een taak toevoegd",
                "icon" => "bx:bxs-error-alt"
            ];
        }
        return $this->render('admin/task/index.html.twig', [
            'tasks' => $tasks,
            'title' => 'Taken',
            'alert' => $alert
        ]);
    }

    /**
     * @Route("/new", name="add")
     * @param Request $r
     * @return Response
     */
    public function add(Request $r) {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);


        $form->handleRequest($r);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();


            // Save to db
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks_index');
        }

        return $this->render('admin/task/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Nieuwe Taak toevoegen'
        ]);
    }
}
