<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendsRepository")
 */
class Friends
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_followed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friends")
     * @ORM\JoinColumn(nullable=false)
     */
    private $follower;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFollowed(): ?int
    {
        return $this->id_followed;
    }

    public function setIdFollowed(int $id_followed): self
    {
        $this->id_followed = $id_followed;

        return $this;
    }

    public function getFollower(): ?User
    {
        return $this->follower;
    }

    public function setFollower(?User $user): self
    {
        $this->follower = $user;

        return $this;
    }
}
