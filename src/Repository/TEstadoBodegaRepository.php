<?php

namespace App\Repository;

use App\Entity\TEstadoBodega;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TEstadoBodega|null find($id, $lockMode = null, $lockVersion = null)
 * @method TEstadoBodega|null findOneBy(array $criteria, array $orderBy = null)
 * @method TEstadoBodega[]    findAll()
 * @method TEstadoBodega[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TEstadoBodegaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TEstadoBodega::class);
    }

//    /**
//     * @return TEstadoBodega[] Returns an array of TEstadoBodega objects
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
    public function findOneBySomeField($value): ?TEstadoBodega
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
