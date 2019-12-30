<?php

namespace App\Controller;

use App\Entity\Period;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/admin/{period}/email", name="mail_period")
     * @param Period $period
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    public function index(Period $period,MailerInterface $mailer, Request $r)
    {
        $referer = $r->headers->get('referer');
        if (!$referer) {
            $redirect = $this->generateUrl("page_index");
            return $this->redirect($redirect);
        } else {
            $redirect = $referer;
        }
        $mailURL = $this->generateUrl('page_show_period', [
            "client" => $period->getClient()->getUsername(),
            "start" => date_format($period->getStartDate(), 'Y-m-d'),
            "end" => date_format($period->getEndDate(), 'Y-m-d')
        ]);
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@arte-tech.null', 'Arte-Tech'))
            ->to($period->getClient()->getEmail())
            ->subject("Afgeronde periode: ".date_format($period->getStartDate(), 'd-m-Y')."—".date_format($period->getEndDate(), 'd-m-Y'))
            ->htmlTemplate('mail/period.html.twig')
            ->context([
                'period' => $period,
                'url' => 'http://localhost:8000'.$mailURL
            ]);

        $response = $mailer->send($email);

        return $this->redirect($redirect);
    }
}
