<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\AbstractUserCategory;
use App\Utils\Slugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"mail"}, message="Cet email est déjà utilisé par un autre compte !")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20, nullable=true, unique=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplete;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avatar", cascade={"persist"}, fetch="EAGER")
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="follows")
     */
    private $followers;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbFollowers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="followers")
     */
    private $follows;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbFollows;        


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isComplete = false;
        $this->followers = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->nbFollowers = 0;
        $this->nbFollows = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->firstname .' '. $this->lastname;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->getName();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(AbstractUserCategory $category): self
    {
        $this->category = $category->getLabel();

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    public function getSlug()
    {
        return Slugger::slugify($this->getUsername(), '.');
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $this->increaseFollowers();
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
            $this->decreaseFollowers();
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(self $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->addFollower($this);
            $this->increaseFollows();
        }

        return $this;
    }

    public function removeFollow(self $follow): self
    {
        if ($this->follows->contains($follow)) {
            $this->follows->removeElement($follow);
            $follow->removeFollower($this);
            $this->decreaseFollows();
        }

        return $this;
    }

    public function getNbFollowers(): ?int
    {
        return $this->nbFollowers;
    }

    public function setNbFollowers(int $nbFollowers): self
    {
        $this->nbFollowers = $nbFollowers;

        return $this;
    }

    public function increaseFollowers()
    {
        $nbFollowers = $this->getNbFollowers();
        $this->setNbFollowers($nbFollowers+1);
    }

    public function decreaseFollowers()
    {
        $nbFollowers = $this->getNbFollowers();
        $this->setNbFollowers($nbFollowers-1);
    }

    public function getNbFollows(): ?int
    {
        return $this->nbFollows;
    }

    public function setNbFollows(int $nbFollows): self
    {
        $this->nbFollows = $nbFollows;

        return $this;
    }

    public function increaseFollows()
    {
        $nbFollows = $this->getNbFollows();
        $this->setNbFollows($nbFollows+1);
    }

    public function decreaseFollows()
    {
        $nbFollows = $this->getNbFollows();
        $this->setNbFollows($nbFollows-1);
    }
}
