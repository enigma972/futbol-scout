<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testSearch()
    {
        $client = static::createClient();
        $client->request('GET', '/accounts/trouver-un-joueur');

        $output = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Touver un joueur');
        $this->assertContains('Trouvez facilement des joueurs en comobinant plusieurs critères.', $output);
    }
}
