<?php

// Tout ce qui est lié à la gestion du panier

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_page')]

    public function index(): Response
    {
        return $this->render('CartPage/cart.html.twig');
    }
}
