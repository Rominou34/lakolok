<?php

namespace App\Repository;

use App\Entity\Spending;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Spending|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spending|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spending[]    findAll()
 * @method Spending[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpendingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spending::class);
    }

    // /**
    //  * @return Spending[] Returns an array of Spending objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spending
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
