<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/feed", name="feed")
     */
    public function index()
    {
        $user = $this->getUser();

        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findFeed($user);

        dump($messages);

        return $this->render('feed/index.html.twig', [
            'user' => $user
        ]);
    }
}
