<?php


namespace App\Manager;


use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function allCommentaire()
    {
        return $this->em->getRepository(Commentaire::class)->findBy([
            'type'=>true,
        ]);
    }

    public function create(Commentaire $commentaire, User $user, $idPublication)
    {
        $publication = $this->em->getRepository(Publication::class)->find($idPublication);

        if ($publication instanceof Publication){
            $commentaire->setPublications($publication);
            $commentaire->setUsers($user);
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setUpdatedAt(new \DateTime());
            $this->em->persist($commentaire);
            $this->em->flush();
        }
    }

    public function updated(Commentaire $commentaire)
    {
        $commentaire->setUpdatedAt(new \DateTime());
        $this->em->persist($commentaire);
        $this->em->flush();
    }

    public function delete(Commentaire $commentaire)
    {
        $this->em->remove($commentaire);
        $this->em->flush();
    }
}