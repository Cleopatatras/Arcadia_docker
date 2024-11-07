<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\AddServiceFormType;
use App\Repository\ServicesRepository;
use App\Service\ImageUploader;
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
        $service = new Services();
        $serviceForm = $this->createForm(AddServiceFormType::class, $service);

        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {
            $image = $serviceForm->get('image')->getData();
            $imageLoad = $pictureServiceNorm->upload($image, 'services');
            $service->setImage($imageLoad);

            $em->persist($service);
            $em->flush();

            $this->addFlash('succes', 'service ajouté avec succès');

            return $this->redirectToRoute('app_espace_admin');
        }

        return $this->render('services/add.html.twig', [
            'serviceForm' => $serviceForm->createView(),
        ]);

    }

}