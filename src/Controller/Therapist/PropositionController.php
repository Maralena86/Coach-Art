<?php

namespace App\Controller\Therapist;

use App\Entity\ArtEvent;
use App\Form\ArtEventType;
use App\Form\PropositionType;
use App\Repository\ArtEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropositionController extends AbstractController
{
    #[Route('/proposition', name: 'app_therapist_proposition')]
    public function index(Request $request, ArtEventRepository $repository): Response
    {
        $form = $this->createForm(ArtEventType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid()){
            $proposition = new ArtEvent();
            $proposition =$form->getData();
            $proposition->setStatus('Not approuved');
            $repository->add($proposition, true);
            $this->addFlash('success', "La proposition a été bien envoyé");
        }

        return $this->render('proposition/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
