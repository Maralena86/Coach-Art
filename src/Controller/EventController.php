<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\DoctrineType\OptionTypeEnum;
use App\DoctrineType\MessageTypeEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EventController extends AbstractController
{
    #[Route('/events', 'app_events_list')]
    function listEvents(EventRepository $repo ):Response{

   
        $events = $repo->findAll();
        return $this->render('events/list.html.twig', ['events'=> $events]);
    }

    #[IsGranted('ROLE_ADMIN')]  
    #[Route('/events/create', 'app_event_create')]
    public function createEvent(EventRepository $repository, Request $request):Response
    {       
        $form= $this->createForm(EventType::class);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $event = $form ->getData();
            $repository->add($event, true);
            $this->addFlash('success', "L'evenement a été bien crée");
            return $this->redirectToRoute('app_home_display');
        }
        return $this->render('events/create.html.twig', [
            'form' =>$form->createView()
        ]);
        
    }
    
    
    #[Route('/events/{id<[0-9]+>}', 'app_event_showDetail')]
    public function showDetail(Event $event): Response{   
        return $this->render('events/showDetail.html.twig', compact('event'));
    }
    
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/events/update/{id}', 'app_event_update')]
    public function updateEvent(EventRepository $repository, Request $request, Event $event): Response
    {
       $form= $this->createForm(EventType::class, $event);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            $event = $form ->getData();
            $repository->add($event, true);
            return $this->redirectToRoute('app_home_display');
        }
        return $this->render('events/update.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/events/delete/{id}', 'app_event_delete')]
    public function deleteEvent(Event $event, EventRepository $repository):Response
    {
        $repository->remove($event, true);
        return $this->redirectToRoute('app_events_list');
    }
    
    
}
