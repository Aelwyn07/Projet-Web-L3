<?php

// Tout ce qui va être lié aux informations utilisateurs (nom, prénom..)

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController

{
    #[Route('/profile', name: 'profile_page')]
    public function index(): Response
    {
        $args = array(
            'name' => 'Thomas',
            'surname' => 'Tefraiche',
        );

        return $this->render('UserPage/profile.html.twig', $args);
    }
}
