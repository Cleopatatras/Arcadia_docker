<?php

namespace App\Controller;

use App\Service\MongoDBService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis_liste', methods: ['GET'])]
    public function listavis(MongoDBService $mongoDBService): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');
        $avis = $collection->find(['isValidated' => true]);

        return $this->render('avis/liste.html.twig', [
            'avis' => $avis,
        ]);
    }

    #[Route('/avis/add', name: 'app_add_avis', methods: ['GET', 'POST'])]
    public function addavis(Request $request, MongoDBService $mongoDBService): Response
    {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $newavis = [
                'pseudo' => $data['pseudo'],
                'etoiles' => (int) $data['etoiles'],
                'title' => $data['title'],
                'comment' => $data['comment'],
                'date' => (new \DateTime())->format(('d-m-Y')),
                'isValidated' => false
            ];

            $collection = $mongoDBService->getCollection('avis_clients');
            $collection->insertOne($newavis);

            $this->addFlash('success', 'L\'avis a été déposé avec succès.');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('avis/add.html.twig');
    }

    #[Route('/avis/edit/{id}', name: 'app_avis_edit', methods: ['GET', 'POST'])]
    public function editavis(Request $request, MongoDBService $mongoDBService, string $id): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');
        $avis = $collection->findOne(['_id' => new ObjectId($id)]);

        if (!$avis) {
            throw $this->createNotFoundException('Avis non trouvé');
        }

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $updatedData = [
                'pseudo' => $data['pseudo'],
                'title' => $data['title'],
                'comment' => $data['comment'],
            ];
            $collection->updateOne(['_id' => new ObjectId($id)], ['$set' => $updatedData]);

            $this->addFlash('success', 'L\'avis a été modifié avec succès.');
            return $this->redirectToRoute('app_avis_liste');
        }

        $avisArray = json_decode(json_encode($avis), true);
        $avisArray['_id'] = (string) $avis['_id'];

        return $this->render('avis/edit.html.twig', [
            'avis' => $avisArray,
        ]);
    }

    #[Route('/avis/delete/{id}', name: 'app_avis_delete', methods: ['POST'])]
    public function deleteavis(MongoDBService $mongoDBService, string $id): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');
        $collection->deleteOne(['_id' => new ObjectId($id)]);

        $this->addFlash('success', 'L\'avis a été supprimé avec succès.');
        return $this->redirectToRoute('app_avis_liste');
    }

    #[Route('/avis/validate', name: 'app_avis_validate', methods: ['GET'])]
    public function validate(MongoDBService $mongoDBService): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');
        $avis = iterator_to_array($collection->find(['isValidated' => false]));

        return $this->render(
            'espace_emp/valider.html.twig',
            [
                'avis' => $avis,
            ]
        );
    }

    #[Route('avis/validate/approve/{id}', name: 'app_avis_approve', methods: ['POST'])]
    public function approuve(string $id, MongoDBService $mongoDBService): Response
    {
        $collection = $mongoDBService->getCollection('avis_clients');

        $result = $collection->updateOne(['_id' => new ObjectId($id)], ['$set' => ['isValidated' => true]]); // Marquer l'avis comme validé

        if ($result->getModifiedCount() > 0) {
            $this->addFlash('success', 'L\'avis a été approuvé avec succès.');
        } else {
            $this->addFlash('error', 'L\'avis n\'a pas pu être approuvé.');
        }

        return $this->redirectToRoute('app_avis_validate');
    }

}