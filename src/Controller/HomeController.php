<?php

declare(strict_types=1);

namespace App\Controller;


use App\Repository\ArtEventRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/', 'app_home_display')]
    function displayHome(ArtEventRepository $repo):Response{
        $events = $repo->findAll();
        
        return $this->render('home/home.html.twig', ['events'=> $events]);
    }
    #[Route('/about', 'app_home_about')]
    function aboutCoachArt():Response{
        
        
        return $this->render('home/about-us.html.twig');
    }
    #[Route('/intervenants', 'app_home_intervenants')]
    public function listIntervenants(UserRepository $repository): Response
    {
        $intervenants = $repository->findTherapist();
        return $this->render('home/intervenants.html.twig', ['intervenants'=>$intervenants]);
        
    }

    

    

}