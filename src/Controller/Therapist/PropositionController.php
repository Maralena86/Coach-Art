<?php

namespace App\Controller\Therapist;

use App\Entity\ArtEvent;
use App\Form\ArtEventType;
use App\Form\PropositionType;
use App\Form\SearchEventType;
use App\DTO\SearchEventCriteria;
use App\Repository\UserRepository;
use App\Repository\ArtEventRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_THERAPIST')] 
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
            $proposition->setStatus('Not approved');
            $proposition->setTherapist($user);
            $repository->add($proposition, true);
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('contact@coach-art-paris.fr')
                ->subject('Ton évenement a été bien transmis!')
                ->htmlTemplate('emails/proposition.html.twig')
                ->context([
                  'user'=>$user
                ]); 
                $mailer->send($email); 
            $this->addFlash('success', "La proposition a été bien envoyé");
        }
        return $this->render('therapist/proposition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/my_events', 'app_therapist_events')]
    function listEventsTherapist(ArtEventRepository $repo, Request $request):Response{
        
        
        $search = new SearchEventCriteria();
        $form = $this->createForm(SearchEventType::class, $search);
        $form->handleRequest($request);

        $events = $repo->findByCriteriaAscEvent($search); 
       
        return $this->render('therapist/events.html.twig', [
            'events' => $events,
            'form' => $form->createView()
    ]);
    }
}
