<?php

namespace App\Controller\Email;


use App\Entity\Contact;
use App\Form\ContactType;

use Symfony\Component\Mime\Email;
use App\Repository\ContactRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_email_contact')]
    public function index( MailerInterface $mailer, Request $request, ContactRepository $repository): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $contact = $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()){
            
            $email = (new TemplatedEmail()) 
                ->from($contact->get('email')->getData())
                ->to('you@example.com')
                ->subject('Votre commande est en traitement')
                ->text('Sending emails is fun again!')
                ->htmlTemplate('mailer/index.html.twig')
                ->context([
                    'name' =>$contact->get('name')->getData(),
                    
                ]);

            $mailer->send($email);
            // $contact = $form->getData();
            // $repository->add($contact, true);
            return $this->redirectToRoute('app_contact');  

        }
        return $this->render('emails/contact.html.twig', [
            'form' =>$form->createView()
            
        ]);




    
        
  

       
    }
}
