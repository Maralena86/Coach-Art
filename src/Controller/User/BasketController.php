<?php

declare(strict_types=1);

namespace App\Controller\User;


use App\Entity\User;
use App\Entity\Article;
use App\Entity\ArtEvent;
use App\Repository\BasketRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class BasketController extends AbstractController
{   
    #[Route('/basket', 'app_basket_display')]
    public function display()
    {   
        return $this->render('user/basket.html.twig');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/basket/{id}/add', 'app_basket_add')]
    public function add(ArtEvent $event, BasketRepository $repository):Response
    {
        /** @var User $user */

        $user =$this->getUser();
        $basket = $user->getBasket();
      
     if(count($basket->getArticles()) > 1){
         foreach($basket->getArticles() as $article){          
                $article->setQuantity($article->getQuantity($article)+1);
            }
    }else{
         $article = new Article();
         $article->setQuantity(1);
    }
                     
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
    } 
    #[Route('basket/{id}/remove', 'app_basket_remove')]
    public function remove(Article $article, ArticleRepository $repository, BasketRepository $basketRepository)
    { 
       
            /** @var User $user */
            $user =$this->getUser();
            $basket = $user->getBasket();
            $repository->remove($article);           
            $basketRepository->add($basket, true);
            return $this->redirectToRoute('app_basket_display');

    } 
    

    


}
