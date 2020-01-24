<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\PlayerSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findAllByQuery(PlayerSearch $search, $page, $nbrParPage = 12)
    {
        $qb = $this->createQueryBuilder('p');
        $expr = $qb->expr();


        $query = $qb->leftJoin('p.page', 'pg')
                    ->addSelect('pg')
                    ->where(
                            $expr->orX(
                                $expr->in('p.firstname', ':fullname'),
                                $expr->in('p.lastname', ':fullname')
                            )
                    )
                    ->orWhere($expr->in('p.nickname', ':fullname'))
                    // ->orWhere($expr->eq('p.license', ':license'))
                    ->orWhere($expr->eq('p.level', ':level'))
                    ->orWhere(
                        $expr->between('p.birthday', ':maxAge', ':minAge')
                    )
                    ->setParameters([
                        'fullname'  =>  $search->getExplodedName(),
                        'minAge'    =>  PlayerSearch::getYearFromAge($search->getMinAge()),
                        'maxAge'    =>  PlayerSearch::getYearFromAge($search->getMaxAge()),
                        // 'license'   =>  $search->getLicense(),
                        'level'     =>  $search->getLevel(),
                    ])
                    ->setFirstResult(($page-1) * $nbrParPage)
                    ->setMaxResults($nbrParPage)
                    ->getQuery();

        return  new Paginator($query);
    }

    // /**
    //  * @return Player[] Returns an array of Player objects
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
    public function findOneBySomeField($value): ?Player
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
