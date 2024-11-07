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
        // Récupère les animaux pour chaque habitat
        $animauxSavane = $animauxRepository->findByHabitatId(3); // ID de la savane
        $animauxJungle = $animauxRepository->findByHabitatId(4); // ID de la jungle
        $animauxMarais = $animauxRepository->findByHabitatId(5); // ID du marais

        return $this->render('animaux/index.html.twig', [
            'animauxSavane' => $animauxSavane,
            'animauxJungle' => $animauxJungle,
            'animauxMarais' => $animauxMarais,
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

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Animaux $animal): Response
    {
        return $this->render('animaux/show.html.twig', [
            'animal' => $animal,
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

    #[Route('/delete/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Animaux $animal, EntityManagerInterface $em): Response
    {
        // Vérifie la validité du token CSRF pour éviter les attaques CSRF
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
            $em->remove($animal);
            $em->flush();

            $this->addFlash('success', 'Animal supprimé');
        } else {
            $this->addFlash('error', 'Token CSRF invalide');
        }

        return $this->redirectToRoute('app_animaux_index');
    }
}