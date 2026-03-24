<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Requête qui retourne la liste des produits disponible dans un pays choisi
    public function findByCountry($country)
    {
        return $this->createQueryBuilder('p')
            ->join('App\Entity\CountryProduct', 'cp', 'WITH', 'cp.product = p')
            ->where('cp.country = :country')
            ->setParameter('country', $country)
            ->getQuery()
            ->getResult();
    }
}
