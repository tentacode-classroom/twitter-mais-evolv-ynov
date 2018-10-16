<?php

namespace App\Controller;

use App\Entity\User;
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
            ->findOneBy(['userName' => $username])
        ;

        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
