<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user/{user}", name="api_user", methods={"GET"})
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(User $user, SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString($serializer->serialize($user, 'json', ["groups" => "settings"]));
    }

    /**
     * @Route("/api/user/{user}", name="api_user_update", methods={"PUT"})
     * @param User $user
     * @param Request $r
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function update(User $user, Request $r, SerializerInterface $serializer) {
        $data = json_decode($r->getContent());
        $user->setCost($data->newCost);
        $user->setTransport($data->newTransport);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return JsonResponse::fromJsonString($serializer->serialize($user, 'json', ["groups" => "settings"]));
    }
}
