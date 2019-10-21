<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostCommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PostComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;



    public function __construct()
    {
        $this->time = new \DateTime();
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

    public function isAuthor(User $user)
    {
        if ($user == $this->getAuthor()) {
            return true;
        }

        return false;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $nbComments = $this->getPost()->getNbComments();
        $this->getPost()->setNbComments($nbComments + 1);
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $nbComments = $this->getPost()->getNbComments();
        $this->getPost()->setNbComments($nbComments - 1);
    }
}
