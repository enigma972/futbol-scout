<?php

namespace App\Repository;

use App\Entity\PlayerPageManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerPageManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerPageManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerPageManager[]    findAll()
 * @method PlayerPageManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerPageManagerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerPageManager::class);
    }

    // /**
    //  * @return PlayerPageManager[] Returns an array of PlayerPageManager objects
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
    public function findOneBySomeField($value): ?PlayerPageManager
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
