<?php

namespace App\Repository;

use App\Entity\TDetalleProyectoMateriales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TDetalleProyectoMateriales|null find($id, $lockMode = null, $lockVersion = null)
 * @method TDetalleProyectoMateriales|null findOneBy(array $criteria, array $orderBy = null)
 * @method TDetalleProyectoMateriales[]    findAll()
 * @method TDetalleProyectoMateriales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TDetalleProyectoMaterialesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TDetalleProyectoMateriales::class);
    }

//    /**
//     * @return TDetalleProyectoMateriales[] Returns an array of TDetalleProyectoMateriales objects
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
    public function findOneBySomeField($value): ?TDetalleProyectoMateriales
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
