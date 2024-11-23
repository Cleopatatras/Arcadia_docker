<?php

namespace App\Controller;

use App\Entity\Animaux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TopAnimauxController extends AbstractController
{
    #[Route('/top/animaux', name: 'app_top_animaux')]
    public function index(EntityManagerInterface $em): Response
    {
        $topAnimaux = $em->getRepository(Animaux::class)->findBy([], ['views' => 'DESC'], 10);

        return $this->render('top_animaux/index.html.twig', [
            'topAnimaux' => $topAnimaux,
        ]);
    }
}