<?php

namespace App\Repository;

use App\Entity\Errand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Errand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Errand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Errand[]    findAll()
 * @method Errand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Errand::class);
    }

    // /**
    //  * @return Errand[] Returns an array of Errand objects
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
    public function findOneBySomeField($value): ?Errand
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
