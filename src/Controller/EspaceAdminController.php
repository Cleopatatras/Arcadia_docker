<?php

namespace App\Controller;

use App\Repository\AnimauxRepository;
use App\Repository\ServicesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function animaux(AnimauxRepository $animauxRepository, Request $request): Response
    {
        //mettre en place le filtre
        $nom = $request->query->get('nom');
        $race = $request->query->get('race');

        // criteres de filtres
        $critere = [];
        if ($nom) {
            $critere['nom'] = $nom;
        }
        if ($race) {
            $critere['race'] = $race;
        }

        $animaux = $animauxRepository->findBy($critere, ['nom' => 'asc']);
        $nom = $animauxRepository->findDistinctNom();
        $race = $animauxRepository->findDistinctRace();

        return $this->render(
            'espace_admin/animaux.html.twig',
            [
                'animaux' => $animaux,
                'nom' => $nom,
                'race' => $race,
            ]
        );
    }

    //Afficher la liste des services

    #[Route('/espace/admin/services', name: 'app_espace_admin_services')]
    public function services(ServicesRepository $servicesRepository, Request $request): Response
    {
        $services = $servicesRepository->findBy([], ['nom' => 'asc']);
        //mettre en place le filtre
        $nom = $request->query->get('nom');
        $description = $request->query->get('description');
        $image = $request->query->get('image');

        return $this->render(
            'espace_admin/services.html.twig',
            [
                'nom' => $nom,
                'description' => $description,
                'image' => $image,
                'services' => $services,
            ]
        );
    }



}