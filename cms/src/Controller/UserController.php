<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/admin/users", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function userIndex() {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array(), ["roles" => "DESC"]);
        return $this->render('admin/users/index.html.twig', [
            "users" => $users,
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $r
     * @param UserPasswordEncoderInterface $passEncoder
     * @return Response
     */
    public function addUser(Request $r, UserPasswordEncoderInterface $passEncoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($r);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setUsername(strtolower(str_split($user->getFirstName(), 4)[0] . str_split($user->getLastName(), 4)[0]));
            $user->setPassword($passEncoder->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Nieuwe gebruiker toevoegen'
        ]);
    }

    /**
     * @param User $user
     * @param Request $r
     * @return Response
     * @Route("/{user}/edit", name="edit")
     */
    public function editUser(User $user, Request $r, UserPasswordEncoderInterface $passEncoder) {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($r);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setUsername(strtolower(str_split($user->getFirstName(), 4)[0] . str_split($user->getLastName(), 4)[0]));
            $user->setPassword($passEncoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'userId' => $user->getId(),
            'form' => $form->createView(),
            'title' => $user->getUsername() . ' bewerken',
        ]);
    }

    /**
     * @param User $user
     * @Route("/{user}/destroy", name="destroy")
     * @return RedirectResponse
     */
    public function destroyUser(User $user) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }
}
