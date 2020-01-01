<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Utils\Slugger;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nickname;

    /**
     * @Assert\Date
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $gender;

    /**
     * @Assert\Country
     * @ORM\Column(type="string", length=255)
     */
    private $country;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerClub")
     * @ORM\JoinColumn(nullable=false)
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerNotice", mappedBy="player", orphanRemoval=true)
     */
    private $notices;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbNotices;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PlayerPicture", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PlayerPage", mappedBy="player", cascade={"persist", "remove"})
     */
    private $page;


    public function __construct()
    {
        $this->birthday = new \DateTime();
        $this->fans = new ArrayCollection();
        $this->nbFans = 0;
        $this->notices = new ArrayCollection();
        $this->nbNotices = 0;
        $this->managers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
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

    public function setStrongFeets(?array $strongFeets): self
    {
        $this->strongFeets = $strongFeets;

        return $this;
    }

    public function getPostes(): ?array
    {
        return $this->postes;
    }

    public function setPostes(?array $postes): self
    {
        $this->postes = $postes;

        return $this;
    }

    public function getCurrentClub(): ?PlayerClub
    {
        return $this->currentClub;
    }

    public function setCurrentClub(?PlayerClub $currentClub): self
    {
        $this->currentClub = $currentClub;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
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
        $birthYear = $this->getBirthday()->format('Y');
        $currentYear = date('Y');
        $age = $currentYear - $birthYear;

        return $age;
    }

    public function getNbNotices(): ?int
    {
        return $this->nbNotices;
    }

    public function setNbNotices(int $nbNotices): self
    {
        $this->nbNotices = $nbNotices;

        return $this;
    }

    /**
     * @return Collection|PlayerNotice[]
     */
    public function getNotices(): Collection
    {
        return $this->notices;
    }

    public function addNotice(PlayerNotice $notice): self
    {
        if (!$this->notices->contains($notice)) {
            $this->notices[] = $notice;
            $notice->setPlayer($this);
        }

        return $this;
    }

    public function removeNotice(PlayerNotice $notice): self
    {
        if ($this->notices->contains($notice)) {
            $this->notices->removeElement($notice);
            // set the owning side to null (unless already changed)
            if ($notice->getPlayer() === $this) {
                $notice->setPlayer(null);
            }
        }

        return $this;
    }

    public function hasNotice(User $user): bool
    {
        return $this->notices->exists(function ($key, $notice) use ($user) {
            if ($user === $notice->getAuthor()) {
                return true;
            }
        });
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountryName()
    {
        return is_null($this->country) ? null : Countries::getName($this->country);
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPicture(): ?PlayerPicture
    {
        return $this->picture;
    }

    public function setPicture(PlayerPicture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getSlug(): ?string
    {
        return Slugger::slugify($this->getName(), '.');
    }

    public function getPage(): ?PlayerPage
    {
        return $this->page;
    }

    public function setPage(?PlayerPage $page): self
    {
        $this->page = $page;

        // set (or unset) the owning side of the relation if necessary
        $newPlayer = null === $page ? null : $this;
        if ($page->getPlayer() !== $newPlayer) {
            $page->setPlayer($newPlayer);
        }

        return $this;
    }
}