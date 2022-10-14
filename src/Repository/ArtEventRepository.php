<?php

namespace App\Repository;

use App\DTO\Admin\SearchEventAdminCriteria;
use Doctrine\ORM\Query;
use App\Entity\ArtEvent;
use App\DTO\SearchEventCriteria;
use App\Form\SearchEventType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ArtEvent>
 *
 * @method ArtEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtEvent[]    findAll()
 * @method ArtEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtEvent::class);
    }

    public function add(ArtEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArtEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ArtEvent[] Returns an array of ArtEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArtEvent
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByCriteriaAscEvent(SearchEventCriteria $search): array
   {
       
       $query = $this
            ->createQueryBuilder('a') 
            ->orderBy('a.date', 'ASC');
            // ->setMaxResults(8)
            // ->setFirstResult((1 - 1) * 8);
            if(!empty($search->options)){
               
                if($search->options == 'Tous'){
                }else
                $query = $query
                ->andWhere('a.options LIKE :val')
                ->setParameter('val', "%$search->options%"); 
            }
            return $query->getQuery()->getResult();
       ;
   }
    
            // if(!empty($search->date)){
                
            //     $query = $query
            //     ->andWhere('a.date LIKE :val')
            //     ->setParameter('val', "%{$search->date}%"); 
            //     var_dump($search->options);   
            // }
   public function findEventAdminCriteria(SearchEventAdminCriteria $search):array
   {
       $query = $this
            ->createQueryBuilder('a')
            ->orderBy('a.date', 'ASC');

        if($search->name){
            $query 
                ->andWhere('a.name LIKE :val')
                ->setParameter('val', "%$search->name%"); 
        }
        if($search->options){      
            if($search->options == 'Tous'){
            }else
            $query 
            ->andWhere('a.options LIKE :val')
            ->setParameter('val', $search->options); 
        }
        if($search->status){
            $query
            ->andWhere('a.status LIKE :val')
            ->setParameter('val', "%$search->status%"); 
        }
        // if($search->therapist){
        //     $query = $query
        //     ->leftJoin('a.therapist', 'user')
        //     ->andWhere('therapist.id IN (:userIds)')
        //     ->setParameter('userIds', "$search->therapist"); 
        // }
        return $query->getQuery()->getResult();               
   }

    public function findByStatus($value)
    {
        return $this->createQueryBuilder('a') 
        ->andWhere('a.status = :val')
        ->setParameter('val', $value)     
        ->orderBy('a.date', 'ASC')
        ->setMaxResults(5)
        ->setFirstResult((1 - 1) * 5)
        ->getQuery()
        ->getResult()
        ;
    }
    public function findByCriteria(SearchEventCriteria $search): array
    { 
        $qb= $this->createQueryBuilder('event');
        if($search->title){
            $qb
                ->andWhere('event.name LIKE :name')
                ->setParameter('name', "%$search->name%");      
        }
        if(!empty($search->categories)){
            $qb
                ->leftJoin('book.categories',  'category')
                ->andWhere('category.id IN (:categoryIds)')
                ->setParameter('categoryIds', $search->categories);
        }
        if($search->minPrice){
            $qb
                ->andWhere('event.price >= :minPrice')
                ->setParameter('minPrice', $search->minPrice);     
        }
        if($search->maxPrice){
             $qb
                ->andWhere('event.price <= :maxPrice')
                ->setParameter('maxPrice', $search->maxPrice); 
        }
        return $qb
            ->orderBy('event.' . $search->orderBy, $search->direction)
            ->setMaxResults($search->limit)
            ->setFirstResult(($search->page - 1) * $search->limit)
            ->getQuery()
            ->getResult();     
    }
}
