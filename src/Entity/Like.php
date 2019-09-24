<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table(name="post_like")
 * @ORM\HasLifecycleCallbacks()
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;
    

    public function __construct()
    {
        $this->time = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
    * @ORM\PrePersist
    */
    public function increase()
    {
        $nbLikes = $this->getPost()->getNbLikes();
        $this->getPost()->setNbLikes($nbLikes+1);
    }

    /**
    * @ORM\PreRemove
    */
    public function decrease()
    {
        $nbLikes = $this->getPost()->getNbLikes();
        $this->getPost()->setNbLikes($nbLikes-1);
    }
}
