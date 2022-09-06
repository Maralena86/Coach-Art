<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin', 'admin_')]
#[IsGranted('ROLE_ADMIN')] 
class AdminUserController extends AbstractController
{
    #[Route('/users', 'users')]
    public function usersList(UserRepository $repository): Response
    {
        return $this->render('admin/users/users.html.twig', [
            'users' => $repository->findAll(),
        ]);
    }
    
}
