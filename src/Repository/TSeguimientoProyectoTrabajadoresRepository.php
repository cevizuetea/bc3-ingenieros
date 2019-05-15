<?php

namespace App\Repository;

use App\Entity\TSeguimientoProyectoTrabajadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TSeguimientoProyectoTrabajadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method TSeguimientoProyectoTrabajadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method TSeguimientoProyectoTrabajadores[]    findAll()
 * @method TSeguimientoProyectoTrabajadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TSeguimientoProyectoTrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TSeguimientoProyectoTrabajadores::class);
    }

//    /**
//     * @return TSeguimientoProyectoTrabajadores[] Returns an array of TSeguimientoProyectoTrabajadores objects
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
    public function findOneBySomeField($value): ?TSeguimientoProyectoTrabajadores
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
