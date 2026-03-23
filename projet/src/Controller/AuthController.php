<?php

// Tout ce qui est lié à la création de compte, la connexion et la déconnexion.

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/login', name: 'login_page')]
    public function login(): Response
    {
        return $this->render('AuthPage/login.html.twig');
    }

    // Redirection vers le formulaire dans FormController
    #[Route('/register', name: 'register_page')]
    public function register(): Response
    {
        return $this->redirect('user_register');
    }

    #[Route('/logout', name: 'logout_page')]
    public function logout(): Response
    {
        return $this->render('AuthPage/logout.html.twig');
    }
}