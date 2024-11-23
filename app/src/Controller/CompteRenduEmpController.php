<?php

namespace App\Controller;

use App\Entity\CompteRendu;
use App\Form\CompteRendu1Type;
use App\Repository\CompteRenduRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte/rendu/emp')]
final class CompteRenduEmpController extends AbstractController
{
    #[Route(name: 'app_compte_rendu_emp_index', methods: ['GET'])]
    public function index(CompteRenduRepository $compteRenduRepository): Response
    {
        return $this->render('compte_rendu_emp/index.html.twig', [
            'compte_rendus' => $compteRenduRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_compte_rendu_emp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compteRendu = new CompteRendu();
        $form = $this->createForm(CompteRendu1Type::class, $compteRendu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($compteRendu);
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_rendu_emp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_rendu_emp/new.html.twig', [
            'compte_rendu' => $compteRendu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_rendu_emp_show', methods: ['GET'])]
    public function show(CompteRendu $compteRendu): Response
    {
        return $this->render('compte_rendu_emp/show.html.twig', [
            'compte_rendu' => $compteRendu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_compte_rendu_emp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompteRendu $compteRendu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteRendu1Type::class, $compteRendu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_rendu_emp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_rendu_emp/edit.html.twig', [
            'compte_rendu' => $compteRendu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_rendu_emp_delete', methods: ['POST'])]
    public function delete(Request $request, CompteRendu $compteRendu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compteRendu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($compteRendu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_rendu_emp_index', [], Response::HTTP_SEE_OTHER);
    }
}
