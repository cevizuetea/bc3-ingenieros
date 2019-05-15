<?php

namespace App\Repository;

use App\Entity\TCargo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TCargo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TCargo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TCargo[]    findAll()
 * @method TCargo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TCargoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TCargo::class);
    }

//    /**
//     * @return TCargo[] Returns an array of TCargo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TCargo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
