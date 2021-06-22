<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // création de 3 utilisateurs
        for($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail("user" . ($i+1) . "@gmail.com");
            $user->setPassword("password");
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
