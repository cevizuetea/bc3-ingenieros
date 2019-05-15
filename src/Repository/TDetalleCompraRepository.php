<?php

namespace App\Repository;

use App\Entity\TDetalleCompra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TDetalleCompra|null find($id, $lockMode = null, $lockVersion = null)
 * @method TDetalleCompra|null findOneBy(array $criteria, array $orderBy = null)
 * @method TDetalleCompra[]    findAll()
 * @method TDetalleCompra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TDetalleCompraRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TDetalleCompra::class);
    }

//    /**
//     * @return TDetalleCompra[] Returns an array of TDetalleCompra objects
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
    public function findOneBySomeField($value): ?TDetalleCompra
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
