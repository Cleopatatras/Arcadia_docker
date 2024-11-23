<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function sendMail(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $emailAddress = $request->request->get('email');
            $messageContent = $request->request->get('message');


            $email = (new Email())
                ->from($emailAddress)
                ->to('contact@zooarcadia.com')
                ->subject('formulaire de contact')
                ->text($messageContent);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Redirection ou affichage d'une page
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig');
    }

}