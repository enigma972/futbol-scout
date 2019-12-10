<?php

namespace App\Repository;

use App\Entity\PostAttachement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostAttachement|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostAttachement|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostAttachement[]    findAll()
 * @method PostAttachement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostAttachementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostAttachement::class);
    }

    // /**
    //  * @return PostAttachement[] Returns an array of PostAttachement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostAttachement
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
