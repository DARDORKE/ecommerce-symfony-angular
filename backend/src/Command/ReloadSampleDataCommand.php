<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:reload-sample-data',
    description: 'Clear all data and reload fresh sample data'
)]
class ReloadSampleDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->warning('This will delete ALL existing data and reload sample data.');
        if (!$io->confirm('Do you want to continue?', false)) {
            $io->note('Operation cancelled.');
            return Command::SUCCESS;
        }

        // Clear existing data
        $io->section('Clearing existing data...');
        
        $this->entityManager->createQuery('DELETE FROM App\Entity\OrderItem')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Order')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Product')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\User')->execute();

        $io->success('Existing data cleared.');

        // Reload sample data
        $io->section('Loading fresh sample data...');
        
        $loadCommand = $this->getApplication()->find('app:load-sample-data');
        $loadCommand->run($input, $output);

        $io->success('Sample data reloaded successfully!');

        return Command::SUCCESS;
    }
}