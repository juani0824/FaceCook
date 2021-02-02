<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
<<<<<<< HEAD
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
=======
>>>>>>> b85ad07a95249c02ff95e915aae945624e1ecec3
     * @ORM\ManyToOne(targetEntity=Publication::class, inversedBy="likes")
     */
    private $publication;

<<<<<<< HEAD
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
=======
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     */
    private $user;

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;
>>>>>>> b85ad07a95249c02ff95e915aae945624e1ecec3

        return $this;
    }

<<<<<<< HEAD
    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;
=======
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
>>>>>>> b85ad07a95249c02ff95e915aae945624e1ecec3

        return $this;
    }
}
