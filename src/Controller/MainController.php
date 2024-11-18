<?php

namespace App\Controller;

use App\Service\MongoDBService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function avis(MongoDBService $mongoDBService): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');
        $avis = $collection->find(['isValidated' => true]);

        return $this->render('main/index.html.twig', [
            'avis' => $avis,
        ]);
    }

    #[route('/mentions légales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('main/mentions.html.twig');
    }
    #[route('/infoPrat', name: 'app_info_prat')]
    public function infos(): Response
    {
        return $this->render('main/infoPrat.html.twig');
    }
}