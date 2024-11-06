<?php

namespace App\Controller;

use App\Repository\AnimauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceVetoController extends AbstractController
{
    #[Route('/espace/veto', name: 'app_espace_veto')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_VETERINAIRE')) {
            return $this->redirectToRoute('app_main');

        }
        return $this->render('espace_veto/index.html.twig', [
            'controller_name' => 'EspaceVetoController',
        ]);
    }

    // afficher la liste des animaux :

    #[Route('/espace/admin/animaux', name: 'app_espace_admin_animaux')]
    public function animaux(animauxRepository $animauxRepository): Response
    {
        $animaux = $animauxRepository->findBy([], ['nom' => 'asc']);

        return $this->render(
            'espace_admin/animaux.html.twig',
            compact('animaux')

        );
    }
}