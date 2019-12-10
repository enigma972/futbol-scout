<?php

namespace App\Repository;

use App\Entity\PlayerPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlayerPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerPicture[]    findAll()
 * @method PlayerPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerPicture::class);
    }

    // /**
    //  * @return PlayerPicture[] Returns an array of PlayerPicture objects
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
    public function findOneBySomeField($value): ?PlayerPicture
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
