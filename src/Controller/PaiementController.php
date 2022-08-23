<?php

declare(strict_types=1);

namespace App\Controller;


use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Basket;
use Stripe\Checkout\Session;
use App\Repository\OrderRepository;
use App\Repository\BasketRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    #[Route('/checkout', 'app_paiement_checkout')]
    public function checkOut():Response
    {
        /** @var User $user */

        $user =$this->getUser();
        $basket = $user->getBasket();
        $price = $basket->getTotalPrice();

       
        Stripe::setApiKey('sk_test_51LYwABJzRBt6SsUOM7Zqbii89wvTqDmw7BO7f1J7hrIzB2h4gmHNysIRPkkCM4uvOxcIp62XoMGIbFvWowcT1eqb00nDZnePjb');
        $session = Session::create([
            'line_items' => [[
              'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                  'name' => 'Other',
                ],
                'unit_amount' => $price*100,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/success',
            'cancel_url' => 'https://127.0.0.1:8000//cancel',
          ]);
        
          return $this->redirect($session->url, 303); 
    }

    #[Route('/success', 'success_url')]
    public function success(OrderRepository $repository):Response
    {
      /** @var User $user */

      $user =$this->getUser();
    
      $basket = $user->getBasket();
      
      $order = new Order();
      $order->setUser($user);
      foreach ($user->getBasket()->getArticles() as $article) {
          $order->addArticle($article);
          $basket->removeArticle($article);
      }
      $repository->add($order, true);
 
 

      return $this->render('payment/success.html.twig', [
        'order' => $order,
      ]);

    }



    #[Route('/cancel', 'cancel_url')]
    public function cancel():Response
    {
        return $this->render('payment/cancel.html.twig');
    }
    
}
