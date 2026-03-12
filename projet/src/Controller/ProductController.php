<?php

// Tout ce qui va être lié directement aux produits

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_page')]
    public function index(): Response
    {
        $args = array(
            'a' => 'c',
            'b' => 'd',
        );

        return $this->render('ProductPage/product.html.twig', $args);
    }
}
