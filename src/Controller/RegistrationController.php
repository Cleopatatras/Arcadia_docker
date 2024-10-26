<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // Récupérer les rôles du formulaire
            $roles = $form->get('roles')->getData();
            $user->setRoles($roles);

            $entityManager->persist($user);
            $entityManager->flush();

            // Rediriger selon le rôle de l'utilisateur
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->redirectToRoute('app_espace_admin_'); // Route pour l'admin
            } elseif (in_array('ROLE_EMPLOYE', $user->getRoles())) {
                return $this->redirectToRoute('app_espace_emp'); // Route pour l'employé
            } elseif (in_array('ROLE_VETERINAIRE', $user->getRoles())) {
                return $this->redirectToRoute('app_espace_veto'); // Route pour le vétérinaire
            } else {
                return $this->redirectToRoute('app_main'); // Route par défaut
            }
        }

        // do anything else you need here, like send an email

        //     return $security->login($user, UserAuthenticator::class, 'main');
        // }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}