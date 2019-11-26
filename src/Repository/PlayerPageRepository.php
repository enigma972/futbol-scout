<?php

namespace App\Repository;

use App\Entity\PlayerPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerPage[]    findAll()
 * @method PlayerPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerPageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerPage::class);
    }

    // /**
    //  * @return PlayerPage[] Returns an array of PlayerPage objects
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
    public function findOneBySomeField($value): ?PlayerPage
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
