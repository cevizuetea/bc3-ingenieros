<?php

namespace App\Repository;

use App\Entity\TProveedor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TProveedor|null find($id, $lockMode = null, $lockVersion = null)
 * @method TProveedor|null findOneBy(array $criteria, array $orderBy = null)
 * @method TProveedor[]    findAll()
 * @method TProveedor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TProveedorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TProveedor::class);
    }

//    /**
//     * @return TProveedor[] Returns an array of TProveedor objects
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
    public function findOneBySomeField($value): ?TProveedor
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
