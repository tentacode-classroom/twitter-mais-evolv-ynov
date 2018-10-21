<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UpdateProfileType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UpdateProfileController extends AbstractController
{
    /**
     * @Route("/settings/profile", name="update_profile")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        #$user = new User();

        $form = $this->createForm(UpdateProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $updatedUser = new User();
            $updatedUser = $form->getData();

            $encrypted = $encoder->encodePassword($updatedUser, $updatedUser->getPassword());
            $updatedUser->setPassword($encrypted);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($updatedUser);
            $entityManager->flush();

            return $this->redirectToRoute('user', ['username' => $updatedUser->getUsername()]);

        }

        return $this->render('update_profile/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/profile/password", name="update_password")
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder) {

        $form = $this->createForm(UpdatePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $data = $form->getData();
            $currentUser = $this->getUser();

            if (!$encoder->isPasswordValid($currentUser, $data['old_password'])) {
                return $this->redirectToRoute('update_password');
            }

            $encodedPassword = $encoder->encodePassword($currentUser, $data['new_password']);

            $currentUser->setPassword($encodedPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();

            return $this->redirectToRoute('user', ['username' => $currentUser->getUsername()]);
        }

        return $this->render('update_profile/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
