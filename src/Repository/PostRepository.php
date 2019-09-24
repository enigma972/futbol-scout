<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * return Post Return a Post object
     */
    /*public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/
    

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findByFollows($user, $follows, $page, $nombreParPage = 10)
    {
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
        }

        $followsIds = [];
        $followsIds [] = $user->getId();

        foreach ($follows as $follow) {
            $followsIds[] = $follow->getId();
        }
        $qb = $this->createQueryBuilder('p');

        $query = $qb->join('p.author', 'u', 'WITH', $qb->expr()->in('u.id', $followsIds))
                    ->addSelect('u')
                    ->leftjoin('p.comments', 'c')
                    ->addSelect('c')
                    ->leftjoin('p.likes', 'l')
                    ->addSelect('l')
                    ->leftjoin('p.attachement', 'attach')
                    ->addSelect('attach')
                    ->orderBy('p.postedAt', 'DESC')
                    ->getQuery()
                ;

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page-1) * $nombreParPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($nombreParPage);
        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }
    

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
