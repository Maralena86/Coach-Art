<?php

namespace App\Controller;

use App\Repository\ArtEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     *@Route("/sitemap.xml", name="app_sitemap", defaults={"_format"="xml"}) 
     */
    #[Route("/sitemap.xml", name:"app_sitemap", defaults:["_format"=>"xml"])]
    public function index(Request $request, ArtEventRepository $artEventRepository): Response
    {
        $hostname =$request->getSchemeAndHttpHost();

        $urls[] = ['loc' =>$this->generateUrl('app_home_display')];
        $urls[] = ['loc' =>$this->generateUrl('app_login')];
        $urls[] = ['loc' =>$this->generateUrl('app_registration')];
        $urls[] = ['loc' =>$this->generateUrl('app_events_list')];
        $urls[] = ['loc' =>$this->generateUrl('app_home_intervenants')];
        foreach($artEventRepository->findAll() as $artEvent){
            $urls[]= ['loc' =>$this->generateUrl('app_event_showDetail', ['id' => $artEvent->getId()])];
        }
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls, 
                'hostname' => $hostname
            ]), 200
        );
        $response->headers->set('Content-type', 'text/xml');
        return $response;
    }
}
