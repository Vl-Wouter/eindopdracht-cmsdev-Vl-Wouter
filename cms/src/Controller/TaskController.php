<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
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
        return $this->render('admin/task/index.html.twig', [
            'tasks' => $tasks,
            'title' => 'Taken'
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
