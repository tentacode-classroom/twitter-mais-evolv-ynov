<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\SignupType;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/signup", name="registration")
     */
    public function index(Request $request)
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $user = $form->getData();
            if (!$user->getProfilePic()) {
                $user->setProfilePic('default_profile.png');
            }
            dump($user);
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
