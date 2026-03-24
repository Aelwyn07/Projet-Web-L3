<?php

// Tout ce qui va être lié directement aux produits

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\User;

final class ProductController extends AbstractController
{
    // A enlever?
    #[Route('/product', name: 'product_page')]
    public function index(): Response
    {
        $args = array(
            'a' => 'c',
            'b' => 'd',
        );

        return $this->render('ProductPage/product.html.twig', $args);
    }

    // Méthode pour afficher les produits sur le site de vente : 
    // -> L'utilisateur doit etre connecté pour identifier son pays
    // -> Une requête est faite pour ne proposer que les produits disponibles dans le pays de l'utilisateur

    #[Route('/products', name: 'product_list')]
    public function listOfProduct(ProductRepository $repo): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $country = $user->getCountry();
        $products = $repo->findByCountry($country);

        $args = array(
            'products' => $products,
        );

        return $this->render('ProductPage/product.html.twig', $args);
    }
}
