<?php
namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Product;
use App\Entity\Country;
use App\Entity\CountryProduct;
class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Création des produits
        $p1 = new Product();
        $p1->setLabel('Guitare');
        $p1->setUnitPrice(599.99);
        $p1->setStock(10);
        $manager->persist($p1);
        $this->addReference('product_guitare', $p1);
        $p2 = new Product();
        $p2->setLabel('Trompette');
        $p2->setUnitPrice(349.99);
        $p2->setStock(5);
        $manager->persist($p2);
        $this->addReference('product_trompette', $p2);
        $p3 = new Product();
        $p3->setLabel('Saxophone');
        $p3->setUnitPrice(49.99);
        $p3->setStock(20);
        $manager->persist($p3);
        $this->addReference('product_saxophone', $p3);
        $p4 = new Product();
        $p4->setLabel('Flute');
        $p4->setUnitPrice(19.99);
        $p4->setStock(15);
        $manager->persist($p4);
        $this->addReference('product_flute', $p4);
        $p5 = new Product();
        $p5->setLabel('Micro');
        $p5->setUnitPrice(29.99);
        $p5->setStock(8);
        $manager->persist($p5);
        $this->addReference('product_micro', $p5);
        $p6 = new Product();
        $p6->setLabel('Batterie');
        $p6->setUnitPrice(39.99);
        $p6->setStock(12);
        $manager->persist($p6);
        $this->addReference('product_batterie', $p6);
        
        // Liaison produits <-> pays via CountryProduct
        $associations = [
            ['product_guitare', 'country_FRA'],
            ['product_guitare', 'country_ESP'],
            ['product_guitare', 'country_ITA'],
            ['product_trompette', 'country_FRA'],
            ['product_saxophone', 'country_FRA'],
            ['product_saxophone', 'country_ITA'],
            ['product_saxophone', 'country_BOS'],
            ['product_flute', 'country_ESP'],
            ['product_flute', 'country_SLV'],
            ['product_flute', 'country_FRA'],
            ['product_flute', 'country_BOS'],
            ['product_micro', 'country_ALL'],
            ['product_micro', 'country_ITA'],
            ['product_micro', 'country_SLV'],
            ['product_micro', 'country_FRA'],
            ['product_micro', 'country_ESP'],
            ['product_micro', 'country_BOS'],
            ['product_batterie', 'country_BOS'],
            ['product_batterie', 'country_SLV'],
        ];
        foreach ($associations as [$prodRef, $countryRef]) {
            $cp = new CountryProduct();
            $cp->setProduct($this->getReference($prodRef, Product::class));
            $cp->setCountry($this->getReference($countryRef, Country::class));
            $manager->persist($cp);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CountriesFixtures::class,
        ];
    }
}