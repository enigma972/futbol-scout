<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerNoticeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlayerNotice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    //private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="notices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLocked;

    



    public function __construct()
    {
        $this->time = new \DateTime();
        $this->isLocked = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $nbNotices = $this->getPlayer()->getNbNotices();
        $this->getPlayer()->setNbNotices($nbNotices + 1);
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $nbNotices = $this->getPlayer()->getNbNotices();
        $this->getPlayer()->setNbNotices($nbNotices - 1);
    }

    public function isAuthor(User $author): bool
    {
        if ($author === $this->author) {
            return true;
        }
        return false;
    }

    public function getIsLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function isLocked(): ?bool
    {
        return $this->getIsLocked();
    }

    public function setIsLocked(bool $isLocked): self
    {
        $this->isLocked = $isLocked;

        return $this;
    }
}
