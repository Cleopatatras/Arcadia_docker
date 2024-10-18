<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceEmpController extends AbstractController
{
    #[Route('/espace/emp', name: 'app_espace_emp')]
    public function index(): Response
    {
        return $this->render('espace_emp/index.html.twig', [
            'controller_name' => 'EspaceEmpController',
        ]);
    }
}
