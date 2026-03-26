<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Country;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        
        $u1 = new User();
        $u1->setLogin('sadmin');
        $u1->setRoles(['ROLE_SUPER_ADMIN']);
        $u1->setName('SUPER');
        $u1->setSurname('Admin');
        $u1->setBirthDate(new \DateTime('2000-01-01'));
        $hashedPassword = $this->passwordHasher->hashPassword($u1, 'nimdas');
        $u1->setPassword($hashedPassword);
        $country = $this->getReference('country_FRA', Country::class);
        $u1->setCountry($country);
        $manager->persist($u1);

        $u2 = new User();
        $u2->setLogin('gilles');
        $u2->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $u2->setName('SUBRENAT');
        $u2->setSurname('Gilles');
        $u2->setBirthDate(new \DateTime('2000-01-01'));
        $hashedPassword = $this->passwordHasher->hashPassword($u2, 'sellig');
        $u2->setPassword($hashedPassword);
        $country = $this->getReference('country_ESP', Country::class);
        $u2->setCountry($country);
        $manager->persist($u2);

        $u3 = new User();
        $u3->setLogin('rita');
        $u3->setRoles(['ROLE_USER']);
        $u3->setName('ZROUR');
        $u3->setSurname('Rita');
        $u3->setBirthDate(new \DateTime('2000-01-01'));
        $hashedPassword = $this->passwordHasher->hashPassword($u3, 'atir');
        $u3->setPassword($hashedPassword);
        $country = $this->getReference('country_ITA', Country::class);
        $u3->setCountry($country);
        $manager->persist($u3);

        $u3 = new User();
        $u3->setLogin('mathieu');
        $u3->setRoles(['ROLE_USER']);
        $u3->setName('CHEDID');
        $u3->setSurname('Mathieu');
        $u3->setBirthDate(new \DateTime('2000-01-01'));
        $hashedPassword = $this->passwordHasher->hashPassword($u3, 'ueihtam');
        $u3->setPassword($hashedPassword);
        $country = $this->getReference('country_ALL', Country::class);
        $u3->setCountry($country);
        $manager->persist($u3);

        $manager->flush();
    }
}
