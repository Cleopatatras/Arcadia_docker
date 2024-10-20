<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaraisController extends AbstractController
{
    #[Route('/marais', name: 'app_marais')]
    public function index(): Response
    {
        return $this->render('marais/index.html.twig', [
            'controller_name' => 'MaraisController',
        ]);
    }
}
