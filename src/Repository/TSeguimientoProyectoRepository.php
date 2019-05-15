<?php

namespace App\Repository;

use App\Entity\TSeguimientoProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TSeguimientoProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TSeguimientoProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TSeguimientoProyecto[]    findAll()
 * @method TSeguimientoProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TSeguimientoProyectoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TSeguimientoProyecto::class);
    }

//    /**
//     * @return TSeguimientoProyecto[] Returns an array of TSeguimientoProyecto objects
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
    public function findOneBySomeField($value): ?TSeguimientoProyecto
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
