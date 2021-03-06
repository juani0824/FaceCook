<?php

namespace App\Repository;

use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    public function lastXRecette($nombre)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = true')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($nombre)
            ->getQuery()
            ->getResult();
    }

    public function lastPRecette(User $user, $nombre)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = true')
            ->andWhere('p.users = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($nombre)
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Publication[] Returns an array of Publication objects
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
    public function findOneBySomeField($value): ?Publication
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
