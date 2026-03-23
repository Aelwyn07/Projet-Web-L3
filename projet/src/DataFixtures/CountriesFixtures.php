<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;

class CountriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $c1 = new Country('FRA', 'France');
        $manager->persist($c1);
        $c2 = new Country('ESP', 'Espagne');
        $manager->persist($c2);
        $c3 = new Country('ITA', 'Italie');
        $manager->persist($c3);
        $c4 = new Country('ALL', 'Allemagne');
        $manager->persist($c4);
        $c5 = new Country('BOS', 'Bosnie');
        $manager->persist($c5);
        $c6 = new Country('SLV', 'Slovaquie');
        $manager->persist($c6);

        $manager->flush();
    }
}
