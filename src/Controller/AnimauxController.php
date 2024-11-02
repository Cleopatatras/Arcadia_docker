<?php

namespace App\Controller;

use App\Entity\Animaux;
use App\Form\AddanimalFormType;
use App\Form\EditAnimalFormType;
use App\Repository\AnimauxRepository;
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
    public function index(AnimauxRepository $animauxRepository): Response
    {
        $animals = $animauxRepository->findAll();
        return $this->render('animaux/index.html.twig', compact('animals'));
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

    #[Route('/edition/{id}', '_edit')]

    public function edit(Animaux $animal, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $animalForm = $this->createForm(EditAnimalFormType::class, $animal);

        $animalForm->handleRequest($request);

        if ($animalForm->isSubmitted() && $animalForm->isValid()) {
            // Handle image update if necessary
            $image = $animalForm->get('image')->getData();
            if ($image) {
                $imageLoad = $pictureService->square($image, 'animal', 300);
                $animal->setImage($imageLoad);
            }

            $em->flush();

            $this->addFlash('success', 'Modification effectuée');

            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('animaux/edit.html.twig', [
            'animalForm' => $animalForm->createView(),
            'animal' => $animal,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_delete')]
    public function delete(Request $request, Animaux $animal, EntityManagerInterface $em): Response
    {
        if (
            $this->isCsrfTokenValid(
                'delete' . $animal->getId(),
                token: $request->getPayload()->getString('_token')
            )
        ) {
            $em->remove($animal);
            $em->flush();
        }
        $this->addFlash('success', 'Animal supprimé');

        return $this->redirectToRoute('app_espace_admin');
    }
}