<?php

namespace App\Repository;

use App\Entity\ObjectivesWeight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjectivesWeight|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectivesWeight|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectivesWeight[]    findAll()
 * @method ObjectivesWeight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectivesWeightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectivesWeight::class);
    }

    // /**
    //  * @return ObjectivesWeight[] Returns an array of ObjectivesWeight objects
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
    public function findOneBySomeField($value): ?ObjectivesWeight
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
