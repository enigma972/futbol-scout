<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAdminCommand extends Command
{
    protected static $defaultName = 'app:add-admin';
    protected $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct();

        $this->em = $entityManagerInterface;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command allow you to add admin')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if ($email) {
            $io->note(sprintf('Passed email: %s', $email));
            $user = $this->em->getRepository(User::class)->findOneByMail($email);

            if ($user instanceOf User) {
                $user->setRoles(["ROLE_ADMIN"]);

                $this->em->persist($user);
                $this->em->flush();

                $name = $user->getName();
                $io->success(sprintf('Successful you have added a new administrator: %s (%s)', $name, $email));
            } else {
                $io->warning(sprintf('User not found with email: %s', $email));
            }
        }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        return 0;
    }
}
