<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends Command
{
    protected static $defaultName = 'app:users-list';
    private $entityManager;

    public function __construct(
        EntityManagerInterface $em
    ) {
        parent::__construct();

        $this->entityManager = $em;
    }

    protected function configure()
    {
        $this->setDescription('List all users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $users = $this->entityManager->getRepository('App:User')->findAll();

        if (!isset($users)) {
            $output->writeln(['', 'No User Yet', '- Use create* commands to manualy create some', '']);    
            return;
        }

        $output->writeln(['', 'Users List ('. count($users) .')', '============', '']);

        foreach ($users as $key => $user) {
            $output->writeln([
                "DisplayName : " . $user->getDisplayName(),
                "Email : " . $user->getEmail(),
                '',
            ]);
        }
    }
}
