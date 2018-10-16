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
        $school = new School();
        $school->setName('Ynov');
        $school->setDescription('La meilleure école d\'informatique');
        $manager->persist($school);

        $manager->flush();
    }
}
