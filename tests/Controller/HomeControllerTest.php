<?php
namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\NeedLogin;
use App\DataFixtures\Users;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLogin;


    public function testHomePageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testHomePageWhenUserIsLogin()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->loadFixtures([Users::class])->getObjectManager();
        $user = $em->getRepository(User::class)->findOneByMail('john@gmail.com');

        $client = static::createClient();

        $this->login($client, $user, 'main');
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Fil d\'actualités');
    }
}
