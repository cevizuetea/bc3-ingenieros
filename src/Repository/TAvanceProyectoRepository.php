<?php

namespace App\Repository;

use App\Entity\TAvanceProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TAvanceProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TAvanceProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TAvanceProyecto[]    findAll()
 * @method TAvanceProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TAvanceProyectoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TAvanceProyecto::class);
    }

//    /**
//     * @return TAvanceProyecto[] Returns an array of TAvanceProyecto objects
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
    public function findOneBySomeField($value): ?TAvanceProyecto
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
