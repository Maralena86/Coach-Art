<?php

declare(strict_types=1);

namespace App\Controller;


use App\Repository\ArtEventRepository;
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
    

    

}