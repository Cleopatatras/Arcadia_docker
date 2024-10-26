<?php

namespace App\Controller;

use App\Repository\AnimauxRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class EspaceAdminController extends AbstractController
{
    #[Route('/espace/admin', name: 'app_espace_admin')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_main');
        }

        return $this->render('espace_admin/index.html.twig', [
            'controller_name' => 'EspaceAdminController',
        ]);
    }

    // afficher la liste des employés :

    #[Route('/espace/admin/liste', name: 'app_espace_admin_list')]
    public function list(UsersRepository $usersRepository): Response
    {
        $list = $usersRepository->findBy([], ['nom' => 'asc']);

        return $this->render(
            'espace_admin/liste.html.twig',
            compact('list')

        );
    }
    // afficher la liste des animaux :

    #[Route('/espace/admin/animaux', name: 'app_espace_admin_animaux')]
    public function animaux(AnimauxRepository $animauxRepository): Response
    {
        $animaux = $animauxRepository->findBy([], ['nom' => 'asc']);

        return $this->render(
            'espace_admin/animaux.html.twig',
            compact('animaux')

        );
    }



}