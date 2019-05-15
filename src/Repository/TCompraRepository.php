<?php

namespace App\Repository;

use App\Entity\TCompra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TCompra|null find($id, $lockMode = null, $lockVersion = null)
 * @method TCompra|null findOneBy(array $criteria, array $orderBy = null)
 * @method TCompra[]    findAll()
 * @method TCompra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TCompraRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TCompra::class);
    }

//    /**
//     * @return TCompra[] Returns an array of TCompra objects
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
    public function findOneBySomeField($value): ?TCompra
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
