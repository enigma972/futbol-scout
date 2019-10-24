<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractUserCategory;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player extends AbstractUserCategory
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $length;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $strongFeets = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $postes = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentClub;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ambition;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biographie;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PlayerPromoClip", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $promoClip;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoritesPlayer")
     */
    private $fans;

    /**
     * @ORM\Column(type="integer") 
     */
    private $nbFans;


    public function __construct()
    {
        // set the user category label with the constant defined in AbstractUserCategory
        $this->setLabel(self::PLAYER);
        $this->fans = new ArrayCollection();
        $this->nbFans = 0;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getStrongFeets(): ?array
    {
        return $this->strongFeets;
    }

    public function setStrongFeets(array $strongFeets): self
    {
        $this->strongFeets = $strongFeets;

        return $this;
    }

    public function getPostes(): ?array
    {
        return $this->postes;
    }

    public function setPostes(array $postes): self
    {
        $this->postes = $postes;

        return $this;
    }

    public function getCurrentClub(): ?string
    {
        return $this->currentClub;
    }

    public function setCurrentClub(string $currentClub): self
    {
        $this->currentClub = $currentClub;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAmbition(): ?string
    {
        return $this->ambition;
    }

    public function setAmbition(?string $ambition): self
    {
        $this->ambition = $ambition;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPromoClip(): ?PlayerPromoClip
    {
        return $this->promoClip;
    }

    public function setPromoClip(?PlayerPromoClip $promoClip): self
    {
        $this->promoClip = $promoClip;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(?string $biographie): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFans(): Collection
    {
        return $this->fans;
    }

    public function addFan(User $fan): self
    {
        if (!$this->fans->contains($fan)) {
            $this->fans[] = $fan;
            $this->increaseFans();
            $fan->addFavoritesPlayer($this);
        }

        return $this;
    }

    public function removeFan(User $fan): self
    {
        if ($this->fans->contains($fan)) {
            $this->fans->removeElement($fan);
            $this->decreaseFans();
            $fan->removeFavoritesPlayer($this);
        }

        return $this;
    }

    public function getNbFans(): ?int
    {
        return $this->nbFans;
    }

    public function setNbFans(int $nbFans): self
    {
        $this->nbFans = $nbFans;

        return $this;
    }

    public function increaseFans()
    {
        $nbFans = $this->getNbFans();
        $this->setNbFans($nbFans+1);
    }

    public function decreaseFans()
    {
        $nbFans = $this->getNbFans();
        $this->setNbFans($nbFans-1);
    }

    public function getAge(): ?int
    {
        $birthYear = $this->getUser()->getBirthday()->format('Y');
        $currentYear = date('Y');
        $age = $currentYear - $birthYear;

        return $age;
    }
}