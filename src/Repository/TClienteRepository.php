<?php

namespace App\Repository;

use App\Entity\TCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method TCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method TCliente[]    findAll()
 * @method TCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TClienteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TCliente::class);
    }

//    /**
//     * @return TCliente[] Returns an array of TCliente objects
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
    public function findOneBySomeField($value): ?TCliente
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
