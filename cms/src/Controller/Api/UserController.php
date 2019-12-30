<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user/{user}", name="api_user")
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(User $user, SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString($serializer->serialize($user, 'json', ["groups" => "employee"]));
    }
}
