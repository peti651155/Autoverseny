<?php

namespace App\DataFixtures;

use App\Entity\Auto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KocsiFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 13; $i++) {
            $auto = new Auto();
            $auto->setModel('Model' . $i);
            $auto->setManufactureYear(rand(1990, 2023));
            $auto->setPower(rand(100, 500)); // Tesztképp 100 és 500 közötti teljesítményekkel
            $auto->setWeight(rand(1000, 2000)); // Tesztképp 1000 és 2000 közötti tömegekkel
            // További mezőket is kitölthetsz...

            $manager->persist($auto);
        }

        $manager->flush();
    }
}
