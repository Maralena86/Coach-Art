<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Form\ChangePasswordFormType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/orders', "user_list_orders")]
    public function listOrders(OrderRepository $orderRepository): Response
    {
        /** @var User $user */
        $user =$this->getUser();
        $orders = $user->getOrders();
        return $this->render('user/orders.html.twig',[
            'orders'=>$orders
        ]);    
    }
    #[Route('/user/count', "user_count")]
    public function showCount(): Response
    {   
        return $this->render('security/show_profil.html.twig');    
    }
   


}
