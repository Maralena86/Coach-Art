<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', 'app_home_display')]
    function displayHome(EventRepository $repo):Response{
        $events = $repo->findAll();
        
        return $this->render('home/home.html.twig', ['events'=> $events]);
    }
    

    

}