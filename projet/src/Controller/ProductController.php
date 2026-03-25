<?php

// Tout ce qui va être lié directement aux produits

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\User;
use App\Form\ProductQuantityType;

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
    public function listOfProduct(ProductRepository $repo, Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $country = $user->getCountry();
        $products = $repo->findByCountry($country);

        $forms = [];
        foreach ($products as $product) {
            $stock = $product->getStock();

            $choices = [];
            for ($i = 0; $i <= $stock; $i++) {
                $choices[$i] = $i;
            }

            $form = $this->createForm(ProductQuantityType::class, null, [
                'quantity_choices' => $choices,
                'action' => $this->generateUrl('cart_add'),
                'method' => 'POST',
            ]);
            // On pré-remplit le champ caché avec l'id du produit
            $form->get('product_id')->setData((string) $product->getId());

            $forms[$product->getId()] = $form->createView();
        }
        
        $args = array(
            'products' => $products,
            'forms' => $forms,
        );

        return $this->render('ProductPage/product.html.twig', $args);
    }
}
