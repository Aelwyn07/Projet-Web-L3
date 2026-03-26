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
        // les references entre les fixtures :
        // https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html#splitting-fixtures-into-separate-files
        $this->addReference('country_FRA', $c1);

        $c2 = new Country('ESP', 'Espagne');
        $manager->persist($c2);
        $this->addReference('country_ESP', $c2);

        $c3 = new Country('ITA', 'Italie');
        $manager->persist($c3);
        $this->addReference('country_ITA', $c3);

        $c4 = new Country('ALL', 'Allemagne');
        $manager->persist($c4);
        $this->addReference('country_ALL', $c4);

        $c5 = new Country('BOS', 'Bosnie');
        $manager->persist($c5);
        $this->addReference('country_BOS', $c5);

        $c6 = new Country('SLV', 'Slovaquie');
        $manager->persist($c6);
        $this->addReference('country_SLV', $c6);

        $manager->flush();
    }
}
