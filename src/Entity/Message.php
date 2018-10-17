<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $author_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $retweet_id;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRetweetId(): ?int
    {
        return $this->retweet_id;
    }

    public function setRetweetId(?int $retweet_id): self
    {
        $this->retweet_id = $retweet_id;

        return $this;
    }
}
