<?php

namespace App\Controller;

use App\Repository\SchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\School;
use App\Form\SignupType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/signup", name="registration")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {

            $user = $form->getData();

            // Set profile pic to default profile photo
            // TODO maybe, by default, set profile pic to null to save some storage in the database
            $user->setProfilePic('default_profile.png');

            // Encrypt password
            $encrypted = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encrypted);

            // Find out which school the user belongs to
            $domain = explode('@', $user->getEmail());
            $domain = explode('.', $domain[1]);
            $domain = $domain[0];
            $schoolRepository = $this->getDoctrine()->getRepository(School::class);
            $school = $schoolRepository->findOneBy(['name' => $domain]);
            // TODO if school not registered in the database, redirect user to error message
            $user->setSchool($school);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
