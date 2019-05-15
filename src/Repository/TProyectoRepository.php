<?php

namespace App\Repository;

use App\Entity\TProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TProyecto[]    findAll()
 * @method TProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TProyectoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TProyecto::class);
    }

//    /**
//     * @return TProyecto[] Returns an array of TProyecto objects
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
    public function findOneBySomeField($value): ?TProyecto
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.nombreproyecto', 'DSC');
    }
}
