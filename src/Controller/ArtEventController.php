<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\ArtEvent;
use App\Form\ArtEventType;
use App\Repository\ArtEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArtEventController extends AbstractController
{
    #[Route('/events', 'app_events_list')]
    function listEvents(ArtEventRepository $repo ):Response{
        $events = $repo->findAll();
        return $this->render('events/list.html.twig', ['events'=> $events]);
    }
   
    #[Route('/events/{id<[0-9]+>}', 'app_event_showDetail')]
    public function showDetail(ArtEvent $event): Response{   
        return $this->render('events/showDetail.html.twig', compact('event'));
    }   
    
}
