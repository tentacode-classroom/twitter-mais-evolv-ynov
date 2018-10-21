<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Friends;

class ModerationController extends AbstractController
{
    /**
     * @Route("/moderation/delete-profile/{userId}", name="delete-profile")
     */
    public function index(int $userId)
    {
        if ($userId === $this->getUser()->getId()) {
            return $this->redirectToRoute('home');
        }

        $entityManager = $this->getDoctrine()->getManager();

        // Supprimer toutes les relations "amis"
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $userId]);

        $relationsFollower = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findBy(['follower' => $user]);

        foreach ($relationsFollower as $relationFollower) {
            $entityManager->remove($relationFollower);
            $entityManager->flush();
        }

        $relationsFollowed = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findBy(['followed' => $user]);

        foreach ($relationsFollowed as $relationFollowed) {
            $entityManager->remove($relationFollowed);
            $entityManager->flush();
        }

        // Supprimer les messages
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['author' => $user]);

        foreach ($messages as $message) {
            $this->deleteRecursively($message->getId());
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/moderation/delete-message/{messageId}", name="delete-message")
     */
    public function deleteMessage(int $messageId) {
        $this->deleteRecursively($messageId);

        return $this->redirectToRoute('home');
    }


    public function deleteRecursively(int $messageId) {
        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findOneBy(['id' => $messageId]);

        $entityManager = $this->getDoctrine()->getManager();


        $childrenMessages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['parent' => $message]);


        if (!empty($childrenMessages)) {
            foreach ($childrenMessages as $childMessage) {
                $this->deleteRecursively($childMessage->getId());
            }
        }

        $entityManager->remove($message);
        $entityManager->flush();
        return;
    }
}
