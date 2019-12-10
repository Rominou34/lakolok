<?php

namespace App\Repository;

use App\Entity\ErrandItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ErrandItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ErrandItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ErrandItem[]    findAll()
 * @method ErrandItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErrandItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ErrandItem::class);
    }

    // /**
    //  * @return ErrandItem[] Returns an array of ErrandItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ErrandItem
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
