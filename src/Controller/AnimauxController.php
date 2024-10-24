<?php

namespace App\Controller;

use App\Entity\Animaux;
use App\Form\AddanimalFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animaux', name: 'app_animaux')]
class AnimauxController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('animaux/index.html.twig', [
            'controller_name' => 'AnimauxController',
        ]);
    }
    #[Route('/ajouter', name: 'add')]
    public function addanimal(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $animal = new Animaux();
        $animalForm = $this->createForm(AddanimalFormType::class, $animal);

        $animalForm->handleRequest($request);

        if ($animalForm->isSubmitted() && $animalForm->isValid()) {
            $image = $animalForm->get('image')->getdata();
            $imageLoad = $pictureService->square($image, 'animal', 300);
            $animal->setImage($imageLoad);

            $em->persist($animal);
            $em->flush();

            $this->addFlash('success', 'Ajout effectué');


            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('animaux/add.html.twig', [
            'animalForm' => $animalForm->createView(),
        ]);
    }

}