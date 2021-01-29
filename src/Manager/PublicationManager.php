<?php


namespace App\Manager;


use App\Entity\Publication;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PublicationManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicationByUser(User $user)
    {
        return $this->em->getRepository(Publication::class)->getPublicationUser($user);
    }

    public function getRecetteByUser(User $user)
    {
        return $this->em->getRepository(Publication::class)->findBy(
            ['type' => true, 'users' => $user->getId()],['created_at' => 'desc']);
        
    }

    public function allRecette()
    {
        return $this->em->getRepository(Publication::class)->findBy(
            ['type'=>true], ['created_at' => 'desc']
        );
    }

    public function allPublication()
    {
        return $this->em->getRepository(Publication::class)->findBy([], ['created_at' => 'desc']);
    }

    public function lastXRecette()
    {
        return $this->em->getRepository(Publication::class)->lastXRecette(4);
    }

    public function lastPRecette(User $user, $cant)
    {
        return $this->em->getRepository(Publication::class)->lastPRecette($user, $cant);
    }

    public function create(Publication $publication, User $user)
    {
        $publication->setUsers($user);
        $publication->setCreatedAt(new \DateTime());
        $publication->setUpdatedAt(new \DateTime());
        $this->em->persist($publication);
        $this->em->flush();

    }

    public function updated(Publication $publication)
    {
        $publication->setUpdatedAt(new \DateTime());
        $this->em->persist($publication);
        $this->em->flush();
    }

    public function delete(Publication $publication)
    {
        $this->em->remove($publication);
        $this->em->flush();
    }
}