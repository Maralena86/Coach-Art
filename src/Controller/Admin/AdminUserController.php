<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/users', 'admin_users_')]
#[IsGranted('ROLE_ADMIN')] 
class AdminUserController extends AbstractController
{
    #[Route('', 'list')]
    public function usersList(UserRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $repository->findAll();
        $users =  $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('admin/users/list.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/{id}', name:"updateUser")]
    public function updateUser(UserRepository $repository, User $user, Request $request)
    {
        
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $repository->add($user, true);
            return $this->redirectToRoute('admin_users_list'); 
        }

        
        return $this->render('admin/users/updateUser.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    
}
