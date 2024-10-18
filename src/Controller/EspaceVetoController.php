<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceVetoController extends AbstractController
{
    #[Route('/espace/veto', name: 'app_espace_veto')]
    public function index(): Response
    {
        return $this->render('espace_veto/index.html.twig', [
            'controller_name' => 'EspaceVetoController',
        ]);
    }
}
