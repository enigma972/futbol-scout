<?php 
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractUserCategory
{
	public const PLAYER = 'player';
	public const FANS = 'fans';
	public const OTHER = 'other';

	/**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $label;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;
	
	
	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLabel(): ?string
	{
		return $this->label;
	}

	public function setlabel(string $label): self
	{
		$this->label = $label;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(User $user): self
	{
		$this->user = $user;
		$this->user->setCategory($this);

		return $this;
	}
}