<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractUserCategory;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FansRepository")
 */
class Fans extends AbstractUserCategory
{
	public function __construct()
    {
        // set the user category label with the constant defined in AbstractUserCategory
    	$this->setLabel(self::FANS);
    }
}