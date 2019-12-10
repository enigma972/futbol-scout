<?php

namespace App\Repository;

use App\Entity\PlayerPromoClip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlayerPromoClip|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerPromoClip|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerPromoClip[]    findAll()
 * @method PlayerPromoClip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerPromoClipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerPromoClip::class);
    }

    // /**
    //  * @return PlayerPromoClip[] Returns an array of PlayerPromoClip objects
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
    public function findOneBySomeField($value): ?PlayerPromoClip
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
