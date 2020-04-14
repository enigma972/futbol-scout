<?php

namespace App\Tests\Controller;

use App\DataFixtures\Users;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;


    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            'mail' => 'john@doe.fr',
            'password' => 'fakepassword'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-warning');
    }

    public function testSuccessfullLogin()
    {
        $this->loadFixtures([Users::class]);

        $client = static::createClient();
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');

        $client->request('POST', '/login', [
            '_csrf_token' => $csrfToken,
            'mail' => 'john@gmail.com',
            'password' => 'user'
        ]);
        $this->assertResponseRedirects('/');
    }
}
