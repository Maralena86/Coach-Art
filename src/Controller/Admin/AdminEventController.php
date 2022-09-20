<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use App\Entity\ArtEvent;
use App\Form\ArtEventType;
use App\Repository\ArtEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', 'admin_')]
#[IsGranted('ROLE_ADMIN')] 
class AdminEventController extends AbstractController
{ 
    #[Route('/events', 'event_list')]
    public function listEvents(ArtEventRepository $repository):Response
    {
        return $this->render('admin/event/list.html.twig', [
            'events'=>$repository->findAll() ]);
    }

    #[Route('/events/create', 'event_create')]
    public function createEvent(ArtEventRepository $repository, Request $request):Response
    {       
        $form= $this->createForm(ArtEventType::class);

        $form->handleRequest($request);
        $event = new ArtEvent();

        if( $form->isSubmitted() && $form->isValid()){
            $event = $form ->getData();
            
            $repository->add($event, true);
            $this->addFlash('success', "L'evenement a été bien crée");
            return $this->redirectToRoute('app_events_list');
        }
        return $this->render('admin/event/create.html.twig', [
            'form' =>$form->createView()
        ]);       
    }

    #[Route('/events/update/{id}', 'event_update')]
    public function updateEvent(ArtEventRepository $repository, Request $request, ArtEvent $event): Response
    {
       $form= $this->createForm(ArtEventType::class, $event);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            $event = new ArtEvent();
            $event = $form ->getData();
            $repository->add($event, true);
            return $this->redirectToRoute('admin_event_list');
        }
        return $this->render('admin/event/update.html.twig', [
            'form'=> $form->createView()
        ]);
    }
    
    #[Route('/events/delete/{id}', 'event_delete')]
    public function deleteEvent(ArtEvent $event, ArtEventRepository $repository):Response
    {
        foreach($event->getUsers() as $ev){
            if($ev->getId()){
                $this->addFlash('danger', "Ce n'est pas possible d'éliminer");
            return $this->redirectToRoute('app_events_list');   
            }       
        }
        $repository->remove($event, true);
        $this->addFlash('succes', "L'event a été effacé");
        return $this->redirectToRoute('app_events_list');
    }
        

    #[Route('/events/approuved', 'event_approuved')]
    public function listApprouved(ArtEventRepository $repository):Response
    {

        return $this->render('admin/event/approved.html.twig', [
            'events'=>$repository->findByStatus('Approved') ]);
    }
    
    #[Route('/events/notApprouved', 'event_notApprouved')]
    public function listNotApprouved(ArtEventRepository $repository):Response
    {
        return $this->render('admin/event/notApproved.html.twig', [
            'events'=>$repository->findByStatus('Not approved') ]);
    }

    #[Route('/events/check/{id}', 'event_check')]
    public function checkEvent(ArtEventRepository $repository, ArtEvent $event)
    {
        $event->setStatus('Approved');
        $repository->add($event, true);
        return $this->redirectToRoute('admin_event_approuved');
    }
    


    
    
}
