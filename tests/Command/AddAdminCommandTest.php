<?php

namespace App\Tests\Command;

use App\DataFixtures\Users;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class AddAdminCommandTest extends KernelTestCase
{
    use FixturesTrait;


    public function testExecute()
    {
        /** @var EntityManagerInterface $em */
        $this->loadFixtures([Users::class]);

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:add-admin');
        $commandTester = new CommandTester($command);
        
        $commandTester->execute([
            'command'  => $command->getName(),
            'email' => 'john@gmail.com',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        $this->assertContains('Successful you have added a new administrator: doe john (john@gmail.com)', $output);
    }

    public function testExecuteWithNoExistUser()
    {
        /** @var EntityManagerInterface $em */
        $this->loadFixtures([Users::class]);

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:add-admin');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command'  => $command->getName(),
            'email' => 'test@futbol-scout.com',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        $this->assertContains('User not found with email: test@futbol-scout.com', $output);
    }
}
