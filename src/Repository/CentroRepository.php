<?php

namespace App\Repository;

use App\Entity\Centro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Centro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centro[]    findAll()
 * @method Centro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroRepository extends ServiceEntityRepository
{
    public const PAGINADOR_POR_PAGINA = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centro::class);
    }

    public function getCentrosAll(){
        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->addSelect('c.nombre')
            ->addSelect('c.matricula')
            ->addSelect('c.departamento')
            ->orderBy('c.nombre','ASC')
            ->getQuery()
        ;
    }

    public function getPaginadorCentro (int $offset): Paginator
    {
        $consulta = $this->createQueryBuilder('cent')//Definimos un alias para la tabla principal (CENTRO)
            ->orderBy('cent.nombre', 'ASC') //Definimos el orden alfabetico que se mostrara
            ->setMaxResults(self::PAGINADOR_POR_PAGINA) //Mencionamos cuantos resgistros se mostraran por pagina
            ->setFirstResult($offset)
            ->getQuery()
        ;
        return new Paginator($consulta);
    }

    // /**
    //  * @return Centro[] Returns an array of Centro objects
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
    public function findOneBySomeField($value): ?Centro
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
