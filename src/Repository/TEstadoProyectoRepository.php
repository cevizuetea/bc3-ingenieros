<?php

namespace App\Repository;

use App\Entity\TEstadoProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TEstadoProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TEstadoProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TEstadoProyecto[]    findAll()
 * @method TEstadoProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TEstadoProyectoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TEstadoProyecto::class);
    }

//    /**
//     * @return TEstadoProyecto[] Returns an array of TEstadoProyecto objects
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
    public function findOneBySomeField($value): ?TEstadoProyecto
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
