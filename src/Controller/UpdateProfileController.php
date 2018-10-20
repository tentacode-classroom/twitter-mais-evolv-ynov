<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UpdateProfileController extends AbstractController
{
    /**
     * @Route("/update/profile", name="update_profile")
     */
    public function index()
    {
        return $this->render('update_profile/index.html.twig', [
            'controller_name' => 'UpdateProfileController',
        ]);
    }
}
