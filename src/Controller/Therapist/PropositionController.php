<?php

namespace App\Controller\Therapist;

use App\Entity\ArtEvent;
use App\Form\ArtEventType;
use App\Form\PropositionType;
use App\Repository\ArtEventRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class PropositionController extends AbstractController
{
    #[Route('/proposition', name: 'app_therapist_proposition')]
    public function index(Request $request, ArtEventRepository $repository, MailerInterface $mailer, ): Response
    {
        /** @var User $user */

        $user =$this->getUser();

        $form = $this->createForm(PropositionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid()){
            $proposition = new ArtEvent();
            $proposition =$form->getData();
            $proposition->setStatus('Not approuved');
            $proposition->setTherapist($user);
            $repository->add($proposition, true);

            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('adminCoach-art@mail.com')
                ->subject('Ton évenement a été bien transmis!')
                ->htmlTemplate('emails/proposition.html.twig')
                ->context([
                  'user'=>$user
                ]); 
                $mailer->send($email); 

            $this->addFlash('success', "La proposition a été bien envoyé");
        }

        return $this->render('proposition/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
