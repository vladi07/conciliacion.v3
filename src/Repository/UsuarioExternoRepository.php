<?php

namespace App\Repository;

use App\Entity\UsuarioExterno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsuarioExterno|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioExterno|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioExterno[]    findAll()
 * @method UsuarioExterno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioExternoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioExterno::class);
    }

    // /**
    //  * @return UsuarioExterno[] Returns an array of UsuarioExterno objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsuarioExterno
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
