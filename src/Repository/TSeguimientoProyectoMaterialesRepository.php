<?php

namespace App\Repository;

use App\Entity\TSeguimientoProyectoMateriales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TSeguimientoProyectoMateriales|null find($id, $lockMode = null, $lockVersion = null)
 * @method TSeguimientoProyectoMateriales|null findOneBy(array $criteria, array $orderBy = null)
 * @method TSeguimientoProyectoMateriales[]    findAll()
 * @method TSeguimientoProyectoMateriales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TSeguimientoProyectoMaterialesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TSeguimientoProyectoMateriales::class);
    }

//    /**
//     * @return TSeguimientoProyectoMateriales[] Returns an array of TSeguimientoProyectoMateriales objects
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
    public function findOneBySomeField($value): ?TSeguimientoProyectoMateriales
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
