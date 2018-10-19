<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $user = $this->getUser();

        if (!$user) {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('home/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error
            ]);
        }
        else {
            $messages = $this->getDoctrine()
                ->getRepository(Message::class)
                ->findFeed($user);

            return $this->render('home/feed.html.twig', [
                'user' => $user,
                'messages' => $messages
            ]);
        }
    }
}
