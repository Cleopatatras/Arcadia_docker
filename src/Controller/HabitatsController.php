<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Form\AddHabFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/habitats', name: 'app_habitats')]
class HabitatsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('habitats/index.html.twig', [
            'controller_name' => 'HabitatsController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addhabitat(Request $request, EntityManagerInterface $em): Response
    {
        $habitat = new Habitats();
        $habitatForm = $this->createForm(AddHabFormType::class, $habitat);

        $habitatForm->handleRequest($request);

        if ($habitatForm->isSubmitted() && $habitatForm->isValid()) {
            $em->persist($habitat);
            $em->flush();

            $this->addFlash('success', 'Ajout effectué');

            return $this->redirectToRoute('app_main');
        }

        return $this->render('habitats/add.html.twig', [
            'habitatForm' => $habitatForm->createView(),
        ]);
    }

}