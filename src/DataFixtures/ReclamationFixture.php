<?php

namespace App\DataFixtures;

use App\Entity\Reclamation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReclamationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for($i=0;$i<20;$i++)
        {
            $reclamation=new Reclamation();
            $reclamation->setNom($faker->firstName);
            $reclamation->setPrenom($faker->name);
            $reclamation->setEmail($faker->safeEmail);
            $reclamation->setStatus(0);
            $reclamation->setDescription($faker->realText(254));

            $manager->persist($reclamation);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
