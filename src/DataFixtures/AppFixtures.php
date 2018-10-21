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

        $user3 = new User();
        $user3->setFirstName('Marilyn');
        $user3->setLastName('Monroe');
        $user3->setUserName('marilynmonroe');
        $user3->setEmail('marilyn.monroe@ynov.com');
        $user3->setProfilePic('default_profile.png');
        $user3->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user3->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user3->setRoles(['ROLE_ADMIN']);
        $user3->setSchool($school1);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setFirstName('John');
        $user4->setLastName('Wayne');
        $user4->setUserName('johnwayne');
        $user4->setEmail('john.wayne@ynov.com');
        $user4->setProfilePic('default_profile.png');
        $user4->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user4->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user4->setRoles(['ROLE_MOD']);
        $user4->setSchool($school1);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setFirstName('Rita');
        $user5->setLastName('Hayworth');
        $user5->setUserName('ritahayworth');
        $user5->setEmail('rita.hayworth@ynov.com');
        $user5->setProfilePic('default_profile.png');
        $user5->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user5->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user5->setSchool($school1);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setFirstName('Clint');
        $user6->setLastName('Eastwood');
        $user6->setUserName('clinteastwood');
        $user6->setEmail('clint.eastwood@ynov.com');
        $user6->setProfilePic('default_profile.png');
        $user6->setBio('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate vel ex eget ultrices. Praesent lacus turpis, pharetra placerat suscipit at, vulputate vel metus. Vivamus ut elit purus.');
        $user6->setPassword('$2y$13$HPn8PXzrlJFt4mgoj3vJg.HbqiGDuLYFXRNuBjSc6F4L/LhXy/716');
        $user6->setSchool($school1);
        $manager->persist($user6);

        $manager->flush();
    }
}
