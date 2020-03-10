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

    // public function createQueryBuilder($alias, $indexBy = null)
    // {
    //     // dd(__METHOD__);
    //     $qb = parent::createQueryBuilder($alias, $indexBy = null);
    //     $expr = $qb->expr();

    //     return $qb->andWhere($expr->eq("$alias.isSuspended", ':isSuspended'))->setParameter(':isSuspended', false);
    //     // return $qb->andWhere("$alias.isSuspended = :isSuspended")->setParameter(':isSuspended', false);
    // }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        // dd(__METHOD__);
        $criteria['isSuspended'] = false;

        return parent::findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        // dd(__METHOD__);
        $criteria['isSuspended'] = false;

        return parent::findOneBy($criteria, $orderBy = null);
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
                    ->andWhere("p.isSuspended = :isSuspended")
                    ->setParameter(':isSuspended', false)
                    ->setParameter('fullname', $search->getExplodedName())
                    ->setParameter('minAge', PlayerSearch::getYearFromAge($search->getMinAge()))
                    ->setParameter('maxAge', PlayerSearch::getYearFromAge($search->getMaxAge()))
                    // ->setParameter('license', $search->getLicense())
                    ->setParameter('level', $search->getLevel())
                    ->setFirstResult(($page-1) * $nbrParPage)
                    ->setMaxResults($nbrParPage)
                    ->getQuery();

        return  new Paginator($query);
    }

    public function findByIdWithRelatedData($id): ?Player
    {
        $qb = $this->createQueryBuilder('p');
        
        $query = $qb->leftJoin('p.currentClub', 'c')->addSelect('c')
                    ->leftJoin('p.promoClip', 'cl')->addSelect('cl')
                    ->leftJoin('p.picture', 'pict')->addSelect('pict')
                    ->leftJoin('p.notices', 'n')->addSelect('n')
                    ->leftJoin('p.page', 'pg')->addSelect('pg')
                    ->leftJoin('pg.managers', 'm')->addSelect('m')
                    // ->leftJoin('m.user', 'u')->addSelect('u')
                    ->andWhere($qb->expr()->eq('p.id', ':id'))
                    ->andWhere("p.isSuspended = :isSuspended")
                    ->setParameter(':isSuspended', false)
                    ->setParameter('id', $id)
                    ->getQuery()
                    ;

        return $query->getOneOrNullResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */

    public function findPlayersForSuggest($user)
    {
        return $this->createQueryBuilder('p')
            // ->andWhere('u.id != :userId')
            // ->setParameter(':userId', $user->getId(), Type::INTEGER)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
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
