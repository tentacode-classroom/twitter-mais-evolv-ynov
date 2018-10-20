<?php

namespace App\Controller;

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
}
