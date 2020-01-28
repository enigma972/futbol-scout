<?php

namespace App\Repository;

use App\Entity\PlayerClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlayerClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerClub[]    findAll()
 * @method PlayerClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerClub::class);
    }

    /**
     * @return bool Returns a boolean of existing status
     */
    public function notExist(PlayerClub $club)
    {
        $qb = $this->createQueryBuilder('c');

        $result = $qb->where(
                        $qb->expr()->orX(
                            $qb->expr()->in('c.label', ':label'),
                            $qb->expr()->in('c.abbrLabel', ':abbrLabel')
                        )
                    )
                    ->setParameters([
                        'label'     =>  $club->getLabel(),
                        'abbrLabel' =>  $club->getAbbrLabel(),
                    ])
                    ->getQuery()
                    ->getOneOrNullResult()
                ;


        if (null === $result) {
            return true;
        }
        return false;
    }

    // /**
    //  * @return PlayerClub[] Returns an array of PlayerClub objects
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
    public function findOneBySomeField($value): ?PlayerClub
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
