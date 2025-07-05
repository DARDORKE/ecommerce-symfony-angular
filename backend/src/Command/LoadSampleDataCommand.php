<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:load-sample-data',
    description: 'Load sample data for the e-commerce application'
)]
class LoadSampleDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Create admin user
        $adminUser = new User();
        $adminUser->setEmail('admin@example.com');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setFirstName('Admin');
        $adminUser->setLastName('User');
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, 'admin123'));
        $adminUser->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($adminUser);

        // Create regular user
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);

        // Create sample products
        $products = [
            [
                'name' => 'Laptop Dell XPS 13',
                'description' => 'Laptop haute performance avec écran 13 pouces',
                'price' => 1299.99,
                'stock' => 10,
                'category' => 'Electronics',
                'image' => 'laptop-dell-xps13.jpg'
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone Apple dernière génération',
                'price' => 999.99,
                'stock' => 25,
                'category' => 'Electronics',
                'image' => 'iphone-15-pro.jpg'
            ],
            [
                'name' => 'Chaise de bureau ergonomique',
                'description' => 'Chaise confortable pour le travail',
                'price' => 249.99,
                'stock' => 15,
                'category' => 'Furniture',
                'image' => 'chaise-bureau.jpg'
            ],
            [
                'name' => 'Casque Bluetooth Sony',
                'description' => 'Casque audio sans fil haute qualité',
                'price' => 179.99,
                'stock' => 30,
                'category' => 'Electronics',
                'image' => 'casque-sony.jpg'
            ],
            [
                'name' => 'Livre PHP Moderne',
                'description' => 'Guide complet pour apprendre PHP',
                'price' => 39.99,
                'stock' => 50,
                'category' => 'Books',
                'image' => 'livre-php.jpg'
            ]
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            $product->setStock($productData['stock']);
            $product->setCategory($productData['category']);
            $product->setImage($productData['image']);
            $product->setActive(true);
            $product->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $io->success('Sample data loaded successfully!');
        $io->note('Admin user: admin@example.com / admin123');
        $io->note('Regular user: user@example.com / user123');

        return Command::SUCCESS;
    }
}