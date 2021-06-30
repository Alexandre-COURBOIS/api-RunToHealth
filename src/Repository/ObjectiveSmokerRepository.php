<?php

namespace App\Repository;

use App\Entity\ObjectiveSmoker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjectiveSmoker|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectiveSmoker|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectiveSmoker[]    findAll()
 * @method ObjectiveSmoker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectiveSmokerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectiveSmoker::class);
    }

    // /**
    //  * @return ObjectiveSmoker[] Returns an array of ObjectiveSmoker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ObjectiveSmoker
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
