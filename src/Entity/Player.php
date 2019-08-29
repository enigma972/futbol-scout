<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractUserCategory;

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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $level;


    public function __construct()
    {
        // set the user category label with the constant defined in AbstractUserCategory
    	$this->setLabel(self::PLAYER);
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
}