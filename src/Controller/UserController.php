<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Entity\Friends;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}", name="user")
     */
    public function index(string $username)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username])
        ;

        $currentUser = $this->getUser();

        $subscribed = false;

        if ($currentUser) {
            $relation = $this->getDoctrine()
                ->getRepository(Friends::class)
                ->findOneBy([
                    'follower' => $currentUser,
                    'followed' => $user
                ]);

            if ($relation) {
                $subscribed = true;
            } else {
                $subscribed = false;
            }
        }

        // get the number of subscribers
        $subscribers = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findBy(['followed' => $user]);
        $nbSubscribers = count($subscribers);

        // get the number of subscriptions
        $subscriptions = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findBy(['follower' => $user]);
        $nbSubscriptions = count($subscriptions);

        // User messages :
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['author' => $user]);


        return $this->render('user/index.html.twig', [
            'user' => $user,
            'current_user' => $currentUser,
            'subscribed' => $subscribed,
            'nb_subscribers' => $nbSubscribers,
            'nb_subscriptions' => $nbSubscriptions,
            'messages' => $messages
        ]);

    }

    /**
     * @Route("/subscribe/{id}", name="subscribe")
     */
    public function subscribe(int $id) {
        $subscribeTo = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);

        $friendsRow = new Friends();
        $friendsRow->setFollower($this->getUser());
        $friendsRow->setFollowed($subscribeTo);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($friendsRow);
        $entityManager->flush();

        return $this->redirectToRoute('user', ['username' => $subscribeTo->getUsername()]);
    }

    /**
     * @Route("/unsubscribe/{id}", name="unsubscribe")
     */
    public function unsubscribe(int $id) {
        $unsubscribeTo = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);

        $friendsRowToDelete = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findOneBy([
                'follower' => $this->getUser(),
                'followed' => $unsubscribeTo
            ]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($friendsRowToDelete);
        $entityManager->flush();

        return $this->redirectToRoute('user', ['username' => $unsubscribeTo->getUsername()]);
    }
}
