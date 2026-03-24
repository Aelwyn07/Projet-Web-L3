<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Form\CreateAccountType;
use App\Form\EditAccountType;

final class FormController extends AbstractController
{

    // Formulaire permettant à un utilisateur de créer un compte, appelé dans AuthController
    #[Route('/account/register', name: 'user_register')]
    public function userRegisterAction(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Request $request): Response {

        $user = new User();
        $user->setRoles(['Utilisateur']); // L'utilisateur ne choisit pas s'il est admin ou non..
        
        // Lier l'entité au formulaire
        $form = $this->createForm(CreateAccountType::class, $user);
        $form->add('Envoyer', SubmitType::class, ['label' => 'Créer un compte']);
        $form->handleRequest($request);

        // On soumet le formulaire et actualise les attributs de User
        if ($form->isSubmitted() && $form->isValid())
        {
            // Ici on récupèrera le mdp, et on le set à nouveau mais avec le hash
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
        
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'ajout utilisateur réussi');
            return $this->redirectToRoute('user_login');
        }

        if ($form->isSubmitted()) {
            $this->addFlash('info', 'formulaire ajout film incorrect');
        }
            
        $args = array(
            'form' => $form,
            //'myform' => $form->createView(),
        );

        return $this->render('Form/register.html.twig', $args);
    }

    // Formulaire permettant à un utilisateur de modifier les informations de son profil
    #[Route('/account/edit/{id}', name: 'user_edit')]
    public function userEditAction(int $id, EntityManagerInterface $em, Request $request): Response {

        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {throw $this->createNotFoundException("L'utilisateur n'existe pas");}

        $form = $this->createForm(EditAccountType::class, $user);
        $form->add('Envoyer', SubmitType::class, ['label' => 'Modifier le compte']);
        $form->handleRequest($request);

        // A VOIR ICI
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('info', 'Vos modifications sont enregistrées');
            return $this->redirectToRoute('landing_page');
        }

        $args = array(
            'form' => $form,
            //'myform' => $form->createView(),
        );

        return $this->render('Form/edit.html.twig', $args);
    }
}

/*   
    // Formulaire permettant à un administrateur de gérer les comptes utilisateurs
    #[Route('/admin/account/edit', name: 'form_profile_edit')]
    public function adminEditAction(): Response {}

    // Formulaire permettant l'ajout d'un nouveau produit à la base
    #[Route('/contact', name: 'form_contact')]
    public function add(): Response {}
*/



