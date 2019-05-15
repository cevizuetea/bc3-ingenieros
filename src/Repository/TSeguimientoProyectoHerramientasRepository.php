<?php

namespace App\Repository;

use App\Entity\TSeguimientoProyectoHerramientas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TSeguimientoProyectoHerramientas|null find($id, $lockMode = null, $lockVersion = null)
 * @method TSeguimientoProyectoHerramientas|null findOneBy(array $criteria, array $orderBy = null)
 * @method TSeguimientoProyectoHerramientas[]    findAll()
 * @method TSeguimientoProyectoHerramientas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TSeguimientoProyectoHerramientasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TSeguimientoProyectoHerramientas::class);
    }

//    /**
//     * @return TSeguimientoProyectoHerramientas[] Returns an array of TSeguimientoProyectoHerramientas objects
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
    public function findOneBySomeField($value): ?TSeguimientoProyectoHerramientas
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
