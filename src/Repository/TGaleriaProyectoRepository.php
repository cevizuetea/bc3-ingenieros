<?php

namespace App\Repository;

use App\Entity\TGaleriaProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TGaleriaProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TGaleriaProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TGaleriaProyecto[]    findAll()
 * @method TGaleriaProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TGaleriaProyectoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TGaleriaProyecto::class);
    }

//    /**
//     * @return TGaleriaProyecto[] Returns an array of TGaleriaProyecto objects
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
    public function findOneBySomeField($value): ?TGaleriaProyecto
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
