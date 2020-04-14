<?php
namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SettingsControllerTest extends WebTestCase
{
    public function testSettingsRedirectWhenUSerIsNotLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/accounts/settings');

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
}
