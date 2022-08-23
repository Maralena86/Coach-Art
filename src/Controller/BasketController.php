<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\User;
use App\Entity\Event;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends AbstractController
{
    
    #[Route('/basket', 'app_basket_display')]
    public function display()
    {
          /** @var User $user */

          $user =$this->getUser();
          $basket = $user->getBasket();
          $article = $basket->getArticles();
         
        
  

        return $this->render('basket/display.html.twig');

    }

    #[IsGranted('ROLE_USER')]
    #[Route('/basket/{id}/add', 'app_basket_add')]
    public function add(Event $event, BasketRepository $repository, int $id, Request $request):Response
    {
        /** @var User $user */

        $user =$this->getUser();
        $basket = $user->getBasket();
       

        // $session = $request->getSession();
        // $basket = $session->get($user->getEmail());

   
        
        foreach($basket->getArticles() as $article){
            if(($article->getEvent()===$event)){
                $article->setQuantity($article->getQuantity($article)+1); 
                $article->setBasket($basket);
                $article->setEvent($event);  
                $basket->addArticle($article);
                $repository->add($basket, true);
                return $this->redirectToRoute('app_basket_display');            
            }
        }       
                $article = new Article();
                $article->setQuantity(1);
                $article->setBasket($basket);
                $article->setEvent($event);  
                $basket->addArticle($article);

                $repository->add($basket, true);
                return $this->redirectToRoute('app_basket_display');   
    }

    #[Route('basket/{id}/add/increase', 'app_basket_increase')]
    public function increase(Article $article, ArticleRepository $repository)
    {
       
        $article->setQuantity($article->getQuantity($article)+1);
        $repository->add($article, true);
        
        return $this->redirectToRoute('app_basket_display');

   
    }
    #[Route('basket/{id}/add/decrease', 'app_basket_decrease')]
    public function decrease(Article $article, ArticleRepository $repository, BasketRepository $basketRepository)
    {
        $article->setQuantity($article->getQuantity($article)-1);
        if($article->getQuantity($article)<=0){
            /** @var User $user */
            $user =$this->getUser();
            $basket = $user->getBasket();

            $repository->remove($article);
            $basketRepository->add($basket, true);
            return $this->redirectToRoute('app_basket_display');


        }else
        $repository->add($article, true);
        
        
        return $this->redirectToRoute('app_basket_display');

        # code...
    }
    
}
