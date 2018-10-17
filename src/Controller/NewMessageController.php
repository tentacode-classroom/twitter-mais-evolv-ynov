<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewMessageController extends AbstractController
{
    /**
     * @Route("/new/message", name="new_message")
     */
    public function index()
    {
        return $this->render('new_message/index.html.twig', [
            'controller_name' => 'NewMessageController',
        ]);
    }
}
