<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SavaneController extends AbstractController
{
    #[Route('/savane', name: 'app_savane')]
    public function index(): Response
    {
        return $this->render('savane/index.html.twig', [
            'controller_name' => 'SavaneController',
        ]);
    }
}
