<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\CreateAccountType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class AdminController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function getUsers(UserRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('admin/users.html.twig', [
            'users' => $repo->findAll()
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
    public function deleteUser(User $user, EntityManagerInterface $em, CartRepository $cartRepo): Response {

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        if ($user === $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $carts = $cartRepo->findBy(['user' => $user]);
        foreach ($carts as $cart) {
            $em->remove($cart);
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_users');
    }

    #[Route('/admin/add', name: 'admin_add_admin')]
    public function addAdmin(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response {

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $user = new User();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $form = $this->createForm(CreateAccountType::class, $user);
        $form->add('Creer', SubmitType::class, ['label' => 'Créer un admin']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_add_admin');
        }

        $args = array('form' => $form);

        return $this->render('admin/add_admin.html.twig', $args);
    }
}

