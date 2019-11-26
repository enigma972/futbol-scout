<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerPageRepository")
 */
class PlayerPage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", inversedBy="page", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerPageManager", mappedBy="page", orphanRemoval=true)
     */
    private $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return Collection|PlayerPageManager[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(PlayerPageManager $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setPage($this);
        }

        return $this;
    }

    public function removeManager(PlayerPageManager $manager): self
    {
        if ($this->managers->contains($manager)) {
            $this->managers->removeElement($manager);
            // set the owning side to null (unless already changed)
            if ($manager->getPage() === $this) {
                $manager->setPage(null);
            }
        }

        return $this;
    }

    public function isGranted(User $user, string $role): bool
    {
        if (! $user instanceOf User) {
            return false;
        }

        $exist = $this->managers->exists(function ($key, $element) use ($user, $role) {
           if ($element->getUser() == $user) {
                // retrieve manager roles
                $roles = $element->getRoles();
                
                // verify if the manager have the required role
                if (in_array($role, $roles)) {
                    return true;
                }
                return false;
           } 
        });

        return $exist;
    }
}
