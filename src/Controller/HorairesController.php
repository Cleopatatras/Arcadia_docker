<?php

namespace App\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Horaires;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HorairesController extends AbstractController
{
    #[Route('/horaires', name: 'app_horaires')]
    public function index(DocumentManager $dm): Response
    {
        $horaires = $dm->getRepository(Horaires::class)->findAll();

        return $this->render('horaires/index.html.twig', [
            'horaires' => $horaires,
        ]);
    }

    #[Route('/horaires/new', name: 'app_horaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentManager $dm): Response
    {
        if ($request->isMethod('POST')) {
            $horaires = new Horaires();
            $horaires->setJour($request->request->get('jour'));
            $horaires->setOuverture($request->request->get('ouverture'));
            $horaires->setFermeture($request->request->get('fermeture'));

            $dm->persist($horaires);
            $dm->flush();

            return $this->redirectToRoute('app_horaires');
        }

        return $this->render('horaires/new.html.twig');
    }

    #[Route('/horaires/edit/{id}', name: 'app_horaires_edit', methods: ['GET', 'POST'])]
    public function edit(string $id, Request $request, DocumentManager $dm): Response
    {
        $horaires = $dm->getRepository(Horaires::class)->find($id);

        if (!$horaires) {
            throw $this->createNotFoundException('Horaire introuvable.');
        }

        if ($request->isMethod('POST')) {
            $horaires->setJour($request->request->get('jour'));
            $horaires->setOuverture($request->request->get('ouverture'));
            $horaires->setFermeture($request->request->get('fermeture'));

            $dm->flush();

            return $this->redirectToRoute('app_horaires');
        }

        return $this->render('horaires/edit.html.twig', [
            'horaires' => $horaires,
        ]);
    }

    #[Route('/horaires/delete/{id}', name: 'app_horaires_delete', methods: ['POST'])]
    public function delete(string $id, DocumentManager $dm): Response
    {
        $horaires = $dm->getRepository(Horaires::class)->find($id);

        if ($horaires) {
            $dm->remove($horaires);
            $dm->flush();
        }

        return $this->redirectToRoute('app_horaires');
    }

    #[Route('/infoPrat', name: 'app_infoPrat')]
    public function infoPrat(DocumentManager $dm): Response
    {
        // Récupérer tous les horaires
        $horaires = $dm->getRepository(Horaires::class)->findAll();

        // Passer les horaires à la vue Twig
        return $this->render('main/infoPrat.html.twig', [
            'horaires' => $horaires,
        ]);
    }
}