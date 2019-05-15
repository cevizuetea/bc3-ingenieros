<?php

namespace App\Repository;

use App\Entity\THerramienta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method THerramienta|null find($id, $lockMode = null, $lockVersion = null)
 * @method THerramienta|null findOneBy(array $criteria, array $orderBy = null)
 * @method THerramienta[]    findAll()
 * @method THerramienta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class THerramientaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, THerramienta::class);
    }

//    /**
//     * @return THerramienta[] Returns an array of THerramienta objects
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
    public function findOneBySomeField($value): ?THerramienta
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
