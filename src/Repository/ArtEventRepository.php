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
            ->andWhere('a.status LIKE :stat')
            ->setParameter('stat', "Validated")      
            ->orderBy('a.date', 'ASC'); 
            if(!empty($search->options)){
               
                if($search->options == 'Tous'){
                }else
                $query = $query
                ->andWhere('a.options LIKE :val')
                
                ->setParameter('val', "%$search->options%"); 
            }
            // if(!empty($search->date)){
               
                
            //     $query = $query
            //     ->andWhere('a.date LIKE :val')
                
            //     ->setParameter('val', "%$search->date%"); 
            // }
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
       $query = $this->createQueryBuilder('a');
            

        if($search->name){
            $query 
                ->andWhere('a.name LIKE :name')
                ->setParameter('name', "%$search->name%"); 
        }
        if(!empty($search->options)){      
            if($search->options == 'Tous'){
            }else
            $query 
                ->andWhere('a.options LIKE :options')
                ->setParameter('options', "%$search->options%"); 
        }
        if($search->status){
            $query
                ->andWhere('a.status LIKE :status')
                ->setParameter('status', "%$search->status%"); 
        }
        // if($search->therapist){
        //     $query = $query
        //     ->leftJoin('a.therapist', 'user')
        //     ->andWhere('therapist.id IN (:userIds)')
        //     ->setParameter('userIds', "$search->therapist"); 
        // }
      
        return $query
                ->orderBy('a.date', 'ASC')
                ->getQuery()
                ->getResult();               
   }

    public function findByStatus($value)
    {
        return $this->createQueryBuilder('a') 
        ->andWhere('a.status = :val')
        ->setParameter('val', $value)     
        ->orderBy('a.date', 'ASC')

        ->getQuery()
        ->getResult()
        ;
    }
    
}
