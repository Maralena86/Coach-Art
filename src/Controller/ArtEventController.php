<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\SearchEventCriteria;
use App\Entity\ArtEvent;
use App\Form\SearchEventType;
use App\Repository\ArtEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Cache\CacheInterface;

class ArtEventController extends AbstractController
{
    #[Route('/events', 'app_events_list')]
    function listEvents(ArtEventRepository $repo, CacheInterface $cache):Response{
        
        $texte = $cache->get('text_details', function(){});
        $search = new SearchEventCriteria();
        $form = $this->createForm(SearchEventType::class, $search);

        $events = $repo->findByDateAsc($search); 

        return $this->render('events/list.html.twig', [
            'events' => $events,
            'form' => $form->createView()
    ]);
    }
   
    #[Route('/events/{id<[0-9]+>}', 'app_event_showDetail')]
    public function showDetail(ArtEvent $event): Response{   
        return $this->render('events/showDetail.html.twig', compact('event'));
    }  
    
}
