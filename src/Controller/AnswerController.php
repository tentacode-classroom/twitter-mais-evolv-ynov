<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\AnswerMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/answer/{messageId}", name="answer")
     */
    public function index(int $messageId, Request $request)
    {
        $user = $this->getUser();

        $messagesRepository = $this->getDoctrine()->getRepository(Message::class);

        $originalMessage = $messagesRepository->findOneBy(['id' => $messageId]);


        $message = new Message();

        $answerForm = $this->createForm(AnswerMessageType::class, $message);
        $answerForm->handleRequest($request);

        if ($answerForm->isSubmitted() AND $answerForm->isValid()) {
            $message = $answerForm->getData();

            $message->setParent($originalMessage);
            $message->setDate(new \DateTime());
            $message->setAuthor($user);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('answer', ['messageId' => $messageId]);
        }

        $answers = $messagesRepository->findBy(['parent' => $originalMessage], ['date' => 'DESC']);

        return $this->render('answer/index.html.twig', [
            'user' => $user,
            'original_message' => $originalMessage,
            'form' => $answerForm->createView(),
            'answers' => $answers
        ]);
    }
}
