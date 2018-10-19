<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\NewMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class NewMessageController extends AbstractController
{
    /**
     * @Route("/new-message", name="new_message")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(NewMessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {

            $message = $form->getData();
            $message->setAuthor($this->getUser());
            $message->setDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('new_message');

        }

        return $this->render('new_message/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/retweet/{messageId}", name="retweet")
     */
    public function retweet(int $messageId) {
        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findOneBy(['id' => $messageId]);

        $newMessage = new Message();

        $newMessage->setAuthor($this->getUser());
        $newMessage->setDate(new \DateTime());
        $newMessage->setRetweet($message);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($newMessage);
        $entityManager->flush();

        return $this->redirectToRoute('home');

    }
}
