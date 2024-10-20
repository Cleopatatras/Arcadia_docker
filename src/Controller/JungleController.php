<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JungleController extends AbstractController
{
    #[Route('/jungle', name: 'app_jungle')]
    public function index(): Response
    {
        return $this->render('jungle/index.html.twig', [
            'controller_name' => 'JungleController',
        ]);
    }
}
