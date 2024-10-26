<?php

namespace App\Controller;

use App\Entity\Nourriture;
use App\Form\AddNourritureFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/nourriture/ajouter', name: 'app_nourriture_add')]
    public function addnourriture(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $nourriture = new Nourriture();
        $nourritureForm = $this->createForm(AddNourritureFormType::class, $nourriture);

        $nourritureForm->handleRequest($request);

        if ($nourritureForm->isSubmitted() && $nourritureForm->isValid()) {
            $image = $nourritureForm->get('image')->getdata();
            $imageLoad = $pictureService->square($image, 'nourriture', 300);
            $nourriture->setImage($imageLoad);

            $em->persist($nourriture);
            $em->flush();

            $this->addFlash('success', 'Ajout effectué');


            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('nourriture/add.html.twig', [
            'nourritureForm' => $nourritureForm->createView(),
        ]);
    }
}