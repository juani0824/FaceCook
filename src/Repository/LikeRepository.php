<?php

namespace App\Repository;

use App\Entity\Like;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

<<<<<<< HEAD

=======
>>>>>>> b85ad07a95249c02ff95e915aae945624e1ecec3
    public function findPublicationLikedBy(Publication $publication, User $user)
    {
        return $this->createQueryBuilder('l')
            ->join('l.publication', 'pub')
            ->join('l.user', 'user')
            ->andWhere('pub.id = :pubId AND user.id = :userId')
            ->setParameter('pubId', $publication->getId())
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return Like[] Returns an array of Like objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
