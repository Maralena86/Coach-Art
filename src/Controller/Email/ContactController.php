<?php

namespace App\Controller\Email;


use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Address;
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
                ->from(new Address($contact->get('email')->getData()))
                ->to(new Address('contact@coach-art-paris.fr', 'admin'))
                ->subject('Un nouveau message a été envoyé')
                ->text('Sending emails is fun again!')
                ->htmlTemplate('emails/mailer/contact.html.twig')
                ->context([
                    'name' =>$contact->get('name')->getData(),
                    'mail' =>$contact->get('email')->getData(),
                    'message' =>$contact->get('message')->getData(),     
                ]);           

            $mailer->send($email);
            return $this->redirectToRoute('app_email_contact');  

        }
        return $this->render('emails/contact.html.twig', [
            'form' =>$form->createView()
            
        ]);




    
        
  

       
    }
}
