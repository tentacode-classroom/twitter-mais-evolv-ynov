<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\School;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Écoles
        $school1 = new School();
        $school1->setName('Ynov');
        $school1->setDescription('La meilleure école d\'informatique');
        $manager->persist($school1);

        // Utilisateurs
        $user1 = new User();
        $user1->setFirstName('Frank');
        $user1->setLastName('Sinatra');
        $user1->setUserName('franksinatra');
        $user1->setEmail('frank.sinatra@ynov.com');
        $user1->setProfilePic('default_profile.png');
        $user1->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user1->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user1->setSchool($school1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstName('Tony');
        $user2->setLastName('Curtis');
        $user2->setUserName('tonycurtis');
        $user2->setEmail('tony.curtis@ynov.com');
        $user2->setProfilePic('default_profile.png');
        $user2->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user2->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user2->setSchool($school1);
        $manager->persist($user2);

        $manager->flush();
    }
}
