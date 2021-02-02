<?php

namespace App\Repository;

use App\Entity\Favorite;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }


    public function findFavoritePublication(Publication $publication, User $user)
    {
        return $this->createQueryBuilder('f')
            ->join('f.publication', 'pub')
            ->join('f.user', 'user')
            ->andWhere('pub.id = :pubId AND user.id = :userId')
            ->setParameter('pubId', $publication->getId())
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function lastXFavorite(Publication $publication, User $user, $nombre)
    {
        return $this->createQueryBuilder('f')
            ->join('f.publication', 'pub')
            ->join('f.user', 'user')
            ->andWhere('pub.id = :pubId AND user.id = :userId')
            ->setParameter('pubId', $publication->getId())
            ->setParameter('userId', $user->getId())
            ->setMaxResults($nombre)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Favorite[] Returns an array of Favorite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Favorite
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
