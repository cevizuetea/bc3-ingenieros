<?php

namespace App\Repository;

use App\Entity\TMarcab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TMarcab|null find($id, $lockMode = null, $lockVersion = null)
 * @method TMarcab|null findOneBy(array $criteria, array $orderBy = null)
 * @method TMarcab[]    findAll()
 * @method TMarcab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TMarcabRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TMarcab::class);
    }

//    /**
//     * @return TMarcab[] Returns an array of TMarcab objects
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
    public function findOneBySomeField($value): ?TMarcab
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
