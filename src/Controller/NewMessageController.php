<?php

namespace App\Controller;

use App\Form\NewMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/new-message")
 */
class NewMessageController extends AbstractController
{
    /**
     * @Route("/", name="new_message")
     */
    public function index(Request $request)
    {
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
            'form' => $form->createView()
        ]);
    }
}
