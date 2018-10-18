<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser();

        if ($user) {
            $messages = $this->getDoctrine()
                ->getRepository(Message::class)
                ->findFeed($user);

            return $this->render('home/feed.html.twig', [
                'user' => $user,
                'messages' => $messages
            ]);
        }
        return $this->render('home/login.html.twig');
    }
}
