<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            #on génère le token et tout le tintouin:
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
            // // Payload
            // $payload = [

            // ];

            // // On génère le token
            // $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // // Envoyer l'e-mail
            // $mail->send(
            //     'no-reply@openblog.test',
            //     $user->getEmail(),
            //     'Demande de contact',
            //     'register',
            //     compact('user', 'token') // ['user' => $user, 'token'=>$token]
            // );

            // $this->addFlash('success', 'Utilisateur inscrit, veuillez cliquer sur le lien reçu pour confirmer votre adresse e-mail');



        }



        return $this->render('contact/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}