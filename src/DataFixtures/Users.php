<?php
namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class Users extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** @var User */
        $user = new User;
        $avatar = new Avatar;

        $user
            ->setLastname('john')
            ->setFirstname('doe')
            ->setMail('john@gmail.com')
            // password => user
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$BhKEH0Z4RC5WipzFIkYt0Q$QykARO4ORc6/oPPCerh5w4C/QvV/w5m73rWFvEJAFLc')
            ->setBirthday(new \DateTime('-8y'))
            ->setGender('M')
            ->setCountry('CD')
            ->setCategory('player')
            ->setAvatar($avatar)
        ;
    
        $manager->persist($user);

        $manager->flush();
    }
}
