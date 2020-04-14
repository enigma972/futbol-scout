<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\NeedLogin;
use App\DataFixtures\Users;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLogin;


    public function testSearch()
    {
        $em = ($this->loadFixtures([Users::class]))->getObjectManager();
        $user = $em->getRepository(User::class)->findOneByMail('john@gmail.com');

        $client = static::createClient();
        $this->login($client, $user, 'main');
        $client->request('GET', '/accounts/trouver-un-joueur');

        $output = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertContains('Trouvez facilement des joueurs en combinant plusieurs critères.', $output);
    }
}
