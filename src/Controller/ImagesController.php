<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImagesController extends AbstractController
{
    #[Route('/images', name: 'app_images')]
    public function index(): Response
    {
        return $this->render('images/index.html.twig', [
            'controller_name' => 'ImagesController',
        ]);
    }
}
