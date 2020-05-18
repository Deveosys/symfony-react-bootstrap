<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';
    private $entityManager;
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    ) {
        parent::__construct();

        $this->entityManager = $em;
        $this->passwordEncoder = $encoder;
    }

    protected function configure()
    {
        $this->setDescription('Creates a new admin.')
            ->addArgument('displayedName', InputArgument::REQUIRED)
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['', 'Admin Creator', '============', '']);

        $displayedName = $input->getArgument('displayedName');
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');

        $user = new User();
        $user->setDisplayName($displayedName);
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);

        $encodedPassword = $this->passwordEncoder->encodePassword(
            $user,
            $plainPassword
        );
        $user->setPassword($encodedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $output->writeln([
            '',
            'Admin created.',
            '',
            "DisplayName : " . $user->getDisplayName(),
            "Email : " . $user->getEmail(),
            "Password : " . $plainPassword
        ]);
    }
}
