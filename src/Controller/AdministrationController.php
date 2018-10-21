<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/administration/give-role-admin/{userId}", name="give-role-admin")
     */
    public function index(int $userId)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $userId]);

        $roles = ['ROLE_USER', 'ROLE_MOD'];
        $user->setRoles($roles);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user', ['username' => $user->getUsername()]);
    }
}
