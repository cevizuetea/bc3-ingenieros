<?php

namespace App\Repository;

use App\Entity\TDetalleProyectoHerramientas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TDetalleProyectoHerramientas|null find($id, $lockMode = null, $lockVersion = null)
 * @method TDetalleProyectoHerramientas|null findOneBy(array $criteria, array $orderBy = null)
 * @method TDetalleProyectoHerramientas[]    findAll()
 * @method TDetalleProyectoHerramientas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method TDetalleProyectoHerramientas[]    findByProductoId(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TDetalleProyectoHerramientasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TDetalleProyectoHerramientas::class);
    }

//    /**
//     * @return TDetalleProyectoHerramientas[] Returns an array of TDetalleProyectoHerramientas objects
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
    public function findOneBySomeField($value): ?TDetalleProyectoHerramientas
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
