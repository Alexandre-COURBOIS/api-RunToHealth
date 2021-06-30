<?php

namespace App\Repository;

use App\Entity\ObjectiveAlcohol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjectiveAlcohol|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectiveAlcohol|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectiveAlcohol[]    findAll()
 * @method ObjectiveAlcohol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectiveAlcoholRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectiveAlcohol::class);
    }

    // /**
    //  * @return ObjectiveAlcohol[] Returns an array of ObjectiveAlcohol objects
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
    public function findOneBySomeField($value): ?ObjectiveAlcohol
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
