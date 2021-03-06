<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()

    {

       // if (isset($_POST['motEntree']))
        $search_results = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findNameLike($_POST["motEntree"]);



        return $this->render('search/index.html.twig', [

            "search_results" => $search_results

        ]);
    }




}
