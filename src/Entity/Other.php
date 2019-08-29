<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractUserCategory;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OtherRepository")
 */
class Other extends AbstractUserCategory
{
	
}