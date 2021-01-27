<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Manager\PublicationManager;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EmailService $emailService): Response
    {
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $emailService->send(
                $contact->get('email')->getData(),
                'Nicholas_admin@facecook.fr',
                'Nouveau Contact ',
                'contact/email.html.twig',
                [
                    'prenom' => $contact->get('prenom')->getData(),
                    'nom' => $contact->get('nom')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'portable' => $contact->get('portable')->getData(),
                    'message' => $contact->get('message')->getData(),
                ]
            );

            $this->addFlash('message', 'Votre email à bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'ContactForm' => $form->createView(),
           
        ]);
    }
}
