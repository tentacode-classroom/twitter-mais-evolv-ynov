<?php

namespace App\Controller;

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
        $currentUser = $this->getUser();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['userName' => $username])
        ;

        $subscribed = false;

        if ($currentUser) {
            $relation = $this->getDoctrine()
                ->getRepository(Friends::class)
                ->findOneBy([
                    'follower' => $currentUser,
                    'id_followed' => $user->getId()
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
            ->findBy(['id_followed' => $user->getId()]);
        $nbSubscribers = count($subscribers);

        // get the number of subscriptions
        $subscriptions = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findBy(['follower' => $user]);
        $nbSubscriptions = count($subscriptions);


        return $this->render('user/index.html.twig', [
            'user' => $user,
            'current_user' => $currentUser,
            'subscribed' => $subscribed,
            'nb_subscribers' => $nbSubscribers,
            'nb_subscriptions' => $nbSubscriptions
        ]);
    }

    /**
     * @Route("/subscribe/{id}", name="subscribe")
     */
    public function subscribe(int $id) {
        $friendsRow = new Friends();
        $friendsRow->setFollower($this->getUser());
        $friendsRow->setIdFollowed($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($friendsRow);
        $entityManager->flush();

        $userTarget = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);

        return $this->redirectToRoute('user', ['username' => $userTarget->getUsername()]);
    }

    /**
     * @Route("/unsubscribe/{id}", name="unsubscribe")
     */
    public function unsubscribe(int $id) {
        $friendsRowToDelete = $this->getDoctrine()
            ->getRepository(Friends::class)
            ->findOneBy([
                'follower' => $this->getUser(),
                'id_followed' => $id
            ]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($friendsRowToDelete);
        $entityManager->flush();

        $redirectUserTarget = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);

        return $this->redirectToRoute('user', ['username' => $redirectUserTarget->getUsername()]);
    }
}
