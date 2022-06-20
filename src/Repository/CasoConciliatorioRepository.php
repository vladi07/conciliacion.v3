<?php

namespace App\Repository;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CasoConciliatorio|null find($id, $lockMode = null, $lockVersion = null)
 * @method CasoConciliatorio|null findOneBy(array $criteria, array $orderBy = null)
 * @method CasoConciliatorio[]    findAll()
 * @method CasoConciliatorio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasoConciliatorioRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 1;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasoConciliatorio::class);
    }

    public function getCasoPaginator(Centro $centro, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('cs')
            ->andWhere('cs.centro = :centro')
            ->setParameter('centro', $centro)
            ->orderBy('cs.id', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;
        return new Paginator($query);
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
