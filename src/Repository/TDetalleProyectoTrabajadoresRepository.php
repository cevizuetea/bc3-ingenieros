<?php

namespace App\Repository;

use App\Entity\TDetalleProyectoTrabajadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TDetalleProyectoTrabajadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method TDetalleProyectoTrabajadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method TDetalleProyectoTrabajadores[]    findAll()
 * @method TDetalleProyectoTrabajadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TDetalleProyectoTrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TDetalleProyectoTrabajadores::class);
    }

//    /**
//     * @return TDetalleProyectoTrabajadores[] Returns an array of TDetalleProyectoTrabajadores objects
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
    public function findOneBySomeField($value): ?TDetalleProyectoTrabajadores
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
