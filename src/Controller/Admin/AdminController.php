<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Laminas\Code\Generator\EnumGenerator\Name;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin', name:"admin")]
class AdminController extends AbstractController
{
    
    #[Route('/order', name:"_order_list")]
    public function orderList(OrderRepository $repository)
    {
        return $this->render('admin/order.html.twig', [
            'orders' =>$repository->findAll()
        ]);
    }
    #[Route('/therapist', name:"_therapist_list")]
    public function therapistList(UserRepository $repository)
    {
        return $this->render('admin/users/therapists.html.twig', [
             'therapists' =>$repository->findTherapist()
        ]);
    }
    
}
