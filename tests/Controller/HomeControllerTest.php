<?php
namespace Tests\Controller;

use App\Tests\NeedLogin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    use NeedLogin;


    public function testHomePageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testHomePageWhenUserIsLogin()
    {
        $client = static::createClient();

        $users = $this->loadFixtureFiles([__DIR__.'users.yaml']);

        $this->login($client, $users['user_user'], 'main');
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Fil d\'actualités');
    }
}
