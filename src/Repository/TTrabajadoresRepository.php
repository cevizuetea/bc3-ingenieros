<?php

namespace App\Repository;

use App\Entity\TTrabajadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TTrabajadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method TTrabajadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method TTrabajadores[]    findAll()
 * @method TTrabajadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TTrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTrabajadores::class);
    }

//    /**
//     * @return TTrabajadores[] Returns an array of TTrabajadores objects
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
    public function findOneBySomeField($value): ?TTrabajadores
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
