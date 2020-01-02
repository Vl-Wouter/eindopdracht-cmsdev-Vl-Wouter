<?php

namespace App\Controller;

use App\Entity\Period;
use App\Entity\Remark;
use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class PageController
 * @package App\Controller
 * @Route("/", name="page_")
 */
class PageController extends AbstractController
{
    /**
     * @var PeriodRepository
     */
    private $periodRepository;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    /**
     * @Route("", name="index")
     */
    public function index() {
        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/{client}/{start}/{end}", name="show_period", requirements={"start"="[0-9]{4}-[0-9]{2}-[0-9]{2}", "end"="[0-9]{4}-[0-9]{2}-[0-9]{2}"})
     * @param $client
     * @param $start
     * @param $end
     * @return Response
     */
    public function show($client, $start, $end) {
        $period = $this->periodRepository->findOneByClient($client, $start, $end);
        $total = 0;
        if (!$period) {
            return $this->redirectToRoute("page_not_found");
        }
        if ($period->getTasks()) {
            foreach ($period->getTasks() as $task) {
                if ($task->getPrice()) {
                    $total += $task->getPrice();
                }
            }
        }
        return $this->render('page/show.html.twig', [
            'period' => $period,
            'total' => $total
        ]);
    }

    /**
     * @Route("/{period}/confirm", name="confirm_period")
     * @param Period $period
     * @param Request $r
     * @return RedirectResponse
     */
    public function confirmPeriod(Period $period, Request $r) {
        $referer = $r->headers->get('referer');
        if (!$referer) {
            $redirect = $this->generateUrl("page_index");
            return $this->redirect($redirect);
        } else {
            $redirect = $referer;
        }
        $em = $this->getDoctrine()->getManager();
        $period->setConfirmed(true);
        $em->persist($period);
        $em->flush();

        return $this->redirect($redirect);
    }

    /**
     * @Route("/{period}/remark", name="add_remark")
     * @param $period
     * @param Request $r
     * @return RedirectResponse
     * @throws \Exception
     */
    public function addRemark(Period $period, Request $r) {
        $referer = $r->headers->get('referer');
        if (!$referer) {
            $redirect = $this->generateUrl("page_index");
            return $this->redirect($redirect);
        } else {
            $redirect = $referer;
        }
        $remark = new Remark();
        $remark->setPeriod($period);
        $remark->setContent($r->query->get('remark'));
        $remark->setCreated(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($remark);
        $em->flush();
        return $this->redirect($redirect);
    }

    /**
     * @Route("/{client}/{start}/{end}/pdf", name="show_pdf")
     * @param $client
     * @param $start
     * @param $end
     * @return RedirectResponse
     */
    public function showPdf($client, $start, $end) {
        $period = $this->periodRepository->findOneByClient($client, $start, $end);
        $total = 0;
        foreach ($period->getTasks() as $task) {
            if ($task->getPrice()) {
                $total += $task->getPrice();
            }
        }

        // Configure PDF
        $pdf_options = new Options();
        $pdf_options->set('defaultFont', 'Arial');
        $pdf_title = $period->getClient()->getFirstName().$period->getClient()->getLastName().date('Ymd', time());

        $dompdf = new Dompdf($pdf_options);

        $html = $this->renderView('pdf/index.html.twig', [
            'period' => $period,
            'total' => $total,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($pdf_title, [
            "Attachment" => true
        ]);

        return $this->redirectToRoute('page_show_period', ['client' => $client, 'start' => $start, 'end' => $end]);
    }

    /**
     * @Route("404", name="not_found")
     */
    public function notFound() {
        return $this->render('page/notFound.html.twig');
    }

    /**
     * @Route("/style", name="style_guide")
     */
    public function style() {
        return $this->render('page/style.html.twig');
    }
}
