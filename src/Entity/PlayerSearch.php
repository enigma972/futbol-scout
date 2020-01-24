<?php
namespace App\Entity;

use DateTime;

class PlayerSearch
{
    /**
     * @var string
     **/
    public $name;
    /**
     * @var int
     **/
    public $minAge;
    /**
     * @var int
     **/
    public $maxAge;
    /**
     * @var string
     **/
    public $license;
    /**
     * @var string
     **/
    public $level;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;
        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    public function setMaxAge(int $maxAge): self
    {
        $this->maxAge = $maxAge;
        return $this;
    }

    public function getLicense(): ?string
    {
        return empty($this->license)? 'all': $this->license;
    }

    public function setLicense(?string $license): self
    {
        $this->license = $license;
        return $this;
    }

    public function getLevel(): ?string
    {
        return empty($this->level)? 'all': $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;
        return $this;
    }
    
    static public function getYearFromAge(?int $age)
    {
        if (null == $age || 0 == (int)$age) {
            return 0;
        }

        $birthYear = date('Y') - $age;

        $birthday = new DateTime("$birthYear-01-01 00:00:00");

        return $birthday;
    }

    public function getExplodedName()
    {
        return explode(' ', $this->getName());
    }
}
