<?php

namespace App\Repository;

use App\Entity\TTipoBodega;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TTipoBodega|null find($id, $lockMode = null, $lockVersion = null)
 * @method TTipoBodega|null findOneBy(array $criteria, array $orderBy = null)
 * @method TTipoBodega[]    findAll()
 * @method TTipoBodega[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TTipoBodegaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTipoBodega::class);
    }

//    /**
//     * @return TTipoBodega[] Returns an array of TTipoBodega objects
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
    public function findOneBySomeField($value): ?TTipoBodega
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
