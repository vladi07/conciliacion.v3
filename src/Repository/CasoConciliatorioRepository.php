<?php

namespace App\Repository;

use App\Entity\CasoConciliatorio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CasoConciliatorio|null find($id, $lockMode = null, $lockVersion = null)
 * @method CasoConciliatorio|null findOneBy(array $criteria, array $orderBy = null)
 * @method CasoConciliatorio[]    findAll()
 * @method CasoConciliatorio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasoConciliatorioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasoConciliatorio::class);
    }

    // /**
    //  * @return CasoConciliatorio[] Returns an array of CasoConciliatorio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CasoConciliatorio
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
