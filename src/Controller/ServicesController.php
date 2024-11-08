<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\AddServiceFormType;
use App\Repository\ServicesRepository;
use App\Service\PictureServiceNorm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(ServicesRepository $servicesRepository): Response
    {
        $services = $servicesRepository->findAll();

        return $this->render('services/index.html.twig', compact('services'));
    }

    #[Route(path: '/services/ajouter', name: 'app_services_add')]
    public function addservice(Request $request, EntityManagerInterface $em, PictureServiceNorm $pictureServiceNorm): Response
    {
        $services = new Services();
        $serviceForm = $this->createForm(AddServiceFormType::class, $services);

        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {
            $image = $serviceForm->get('image')->getData();
            $imageLoad = $pictureServiceNorm->upload($image, 'services');
            $services->setImage($imageLoad);

            $em->persist($services);
            $em->flush();

            $this->addFlash('succes', 'service ajouté avec succès');

            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('services/add.html.twig', [
            'serviceForm' => $serviceForm->createView(),
        ]);
    }

    #[Route('/services/{id}', name: 'app_services_show', methods: ['GET'])]
    public function show(Services $services): Response
    {
        return $this->render('services/show.html.twig', [
            'service' => $services,
        ]);
    }

    #[Route('services/edition/{id}', 'app_services_edit')]

    public function edit(Services $services, Request $request, EntityManagerInterface $em, PictureServiceNorm $pictureServiceNorm): Response
    {
        $servicesForm = $this->createForm(AddServiceFormType::class, $services);

        $servicesForm->handleRequest($request);

        if ($servicesForm->isSubmitted() && $servicesForm->isValid()) {
            // Handle image update if necessary
            $image = $servicesForm->get('image')->getData();
            if ($image) {
                $imageLoad = $pictureServiceNorm->upload($image, 'services');
                $services->setImage($imageLoad);
            }

            $em->flush();

            $this->addFlash('success', 'Modification effectuée');

            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('services/edit.html.twig', [
            'servicesForm' => $servicesForm->createView(),
            'services' => $services,
        ]);
    }

    #[Route('services/delete/{id}', name: 'app_services_delete', methods: ['POST'])]
    public function delete(Request $request, Services $services, EntityManagerInterface $em): Response
    {
        // Vérifie la validité du token CSRF pour éviter les attaques CSRF
        if ($this->isCsrfTokenValid('delete' . $services->getId(), $request->request->get('_token'))) {
            $em->remove($services);
            $em->flush();

            $this->addFlash('success', 'service supprimé');
        } else {
            $this->addFlash('error', 'Token CSRF invalide');
        }

        return $this->redirectToRoute('app_espace_admin');
    }
}