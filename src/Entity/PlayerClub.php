<?php

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerClubRepository")
 */
class PlayerClub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $abbrLabel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getAbbrLabel(): ?string
    {
        return $this->abbrLabel;
    }

    public function setAbbrLabel(string $abbrLabel): self
    {
        $this->abbrLabel = $abbrLabel;

        return $this;
    }

    public function getSlug()
    {
        return Slugger::slugify($this->getLabel(), '-');
    }
}
