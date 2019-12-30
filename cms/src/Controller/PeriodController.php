<?php

namespace App\Controller;

use App\Entity\Period;
use App\Form\PeriodType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PeriodController
 * @package App\Controller
 * @Route("/admin/period", name="period_")
 */
class PeriodController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $periods = $this->getDoctrine()->getRepository(Period::class)->findAll();
        return $this->render('admin/period/index.html.twig', [
            'periods' => $periods,
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $r
     * @return Response
     */
    public function show(Request $r) {
        $period = new Period();

        $form = $this->createForm(PeriodType::class, $period);

        $form->handleRequest($r);
        if($form->isSubmitted() && $form->isValid()) {
            $period = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($period);
            $em->flush();

            return $this->redirectToRoute('period_index');
        }

        return $this->render('admin/period/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
