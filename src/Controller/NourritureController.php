<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NourritureController extends AbstractController
{
    #[Route('/nourriture', name: 'app_nourriture')]
    public function index(): Response
    {
        return $this->render('nourriture/index.html.twig', [
            'controller_name' => 'NourritureController',
        ]);
    }
}
