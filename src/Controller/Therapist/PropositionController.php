<?php

namespace App\Controller\Therapist;

use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropositionController extends AbstractController
{
    #[Route('/proposition', name: 'app_therapist_proposition')]
    public function index(Request $request, PropositionRepository $repository): Response
    {
        $form = $this->createForm(PropositionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid()){
            $proposition =$form->getData();
            $repository->add($proposition, true);
            $this->addFlash('success', "La proposition a été bien envoyé");
        }

        return $this->render('proposition/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
