<?php

namespace App\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="token_")
 */
class TokenController extends AbstractController
{
    /**
     * @param Request $r
     * @param UserInterface $user
     * @param PasswordEncoderInterface $passwordEncoder
     * @param JWTTokenManagerInterface $JWTTokenManager
     * @return JsonResponse
     * @Route("/token", name="create")
     */
    public function getToken(Request $r, UserInterface $user, PasswordEncoderInterface $passwordEncoder, JWTTokenManagerInterface $JWTTokenManager) {
//        dump($user);
//        return new JsonResponse([
//            'token' => $JWTManager->create($user),
//            'user' => $serializer->serialize($user, 'json', ['groups'=>'login']),
//        ]);
//        return $authenticationSuccessHandler->handleAuthenticationSuccess($user);
        if ($passwordEncoder->isPasswordValid($user->getPassword(), $r->getPassword(), null)) {
            return new JsonResponse([
                'token' => $JWTTokenManager->create($user)
            ]);
        }

        return new JsonResponse([
            'code' => 401,
            'message' => 'Invalid Credentials'
        ]);

    }
}
