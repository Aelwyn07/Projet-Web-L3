<?php

// Tout ce qui est lié à la gestion du panier

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Product;
use App\Form\ProductQuantityType;
use App\Repository\CartRepository;

final class CartController extends AbstractController
{
    #[Route('/temp', name: 'cart_page')]

    public function index(): Response
    {
        return $this->render('CartPage/cart.html.twig');
    }

    #[Route('/cart/add', name: 'cart_add', methods: ['POST'])]
    public function addToCart(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        //$form = $this->createForm(ProductQuantityType::class);
        $form = $this->createForm(ProductQuantityType::class, null,
            ['quantity_choices' => array_combine(range(0, 9999), range(0, 9999)),]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data      = $form->getData();
            $productId = (int) $data['product_id'];
            $quantity  = (int) $data['quantity'];

            $product = $em->getRepository(Product::class)->find($productId);
            if (!$product) {
                throw $this->createNotFoundException('Produit introuvable');
            }

            // Cherche si une ligne panier existe déjà pour cet utilisateur + produit
            $cartRepo = $em->getRepository(Cart::class);
            $cartLine = $cartRepo->findOneBy([
                'user'    => $user,
                'product' => $product,
            ]);

            if ($quantity === 0) {
                // Rien à faire si on choisit 0
            } elseif ($cartLine) {
                // Met à jour la quantité existante
                $cartLine->setQuantity($cartLine->getQuantity() + $quantity);
            } else {
                // Crée une nouvelle ligne panier
                $cartLine = new Cart();
                $cartLine->setUser($user);
                $cartLine->setIdProduct($product);
                $cartLine->setQuantity($quantity);
                $em->persist($cartLine);
            }

            // Diminue le stock du produit
            $product->setStock($product->getStock() - $quantity);

            $em->flush();
        }

        return $this->redirectToRoute('product_list');
    }

    #[Route('/cart', name: 'cart_list')]
    public function listOfCart(CartRepository $repo): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        // Selectionner le contenu du panier de l'utilisateur
        $carts = $repo->findBy(['user' => $user]);
        //$carts = $repo->findByUser($user);

        // total : prix total a payer
        $total = 0;
        foreach($carts as $cart) {
            $total += $cart->getProduct()->getUnitPrice() * $cart->getQuantity();
        }

        $args = array(
            'carts' => $carts,
            'total' => $total,
        );

        return $this->render('CartPage/cart.html.twig', $args);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function removeFromCart(EntityManagerInterface $em, int $id): Response
    {
        $cartLine = $em->getRepository(Cart::class)->find($id);

        if (!$cartLine) {
            throw $this->createNotFoundException('Ligne panier introuvable');
        }

        // On remet à jour le stock du produit
        $product = $cartLine->getProduct();
        $product->setStock($product->getStock() + $cartLine->getQuantity());

        $em->remove($cartLine);
        $em->flush();

        return $this->redirectToRoute('cart_list');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clearCart(CartRepository $repo, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $carts = $repo->findBy(['user' => $user]);

        // On remet à jour les stocks des produits puis on l'enlève du panier
        foreach ($carts as $cartLine) {
            $cartLine->getProduct()->setStock(
                $cartLine->getProduct()->getStock() + $cartLine->getQuantity()
            );
            $em->remove($cartLine);
        }

        $em->flush();
        return $this->redirectToRoute('cart_list');
    }

    #[Route('/cart/command', name: 'cart_command')]
    public function commandCart(CartRepository $repo, EntityManagerInterface $em): Response
{
    $user = $this->getUser();
    $carts = $repo->findBy(['user' => $user]);

    foreach ($carts as $cartLine) {
        $em->remove($cartLine);
    }

    $em->flush();
    return $this->redirectToRoute('cart_list');
}
}
