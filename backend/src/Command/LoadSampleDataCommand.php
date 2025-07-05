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
            // Electronics - Ordinateurs
            [
                'name' => 'Laptop Dell XPS 13',
                'description' => 'Ultrabook haute performance avec écran 13.4" OLED, processeur Intel Core i7-13700H, 16GB RAM, SSD 512GB. Parfait pour les professionnels et étudiants.',
                'price' => 1299.99,
                'stock' => 10,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'MacBook Air avec puce Apple M2, écran Liquid Retina 13.6", 8GB de mémoire unifiée, SSD 256GB. Design ultra-fin et léger.',
                'price' => 1199.99,
                'stock' => 8,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'HP Pavilion Gaming',
                'description' => 'PC portable gaming avec écran 15.6" FHD, processeur AMD Ryzen 5, carte graphique GTX 1650, 8GB RAM, SSD 512GB.',
                'price' => 799.99,
                'stock' => 12,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&h=300&fit=crop'
            ],
            
            // Electronics - Smartphones
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'iPhone 15 Pro avec puce A17 Pro, appareil photo 48 Mpx, écran Super Retina XDR 6.1", 128GB. Disponible en titane naturel.',
                'price' => 999.99,
                'stock' => 25,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Smartphone Android avec écran Dynamic AMOLED 6.2", caméra 50MP, 8GB RAM, 256GB stockage. Intelligence artificielle intégrée.',
                'price' => 849.99,
                'stock' => 20,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Google Pixel 8',
                'description' => 'Pixel 8 avec puce Google Tensor G3, appareil photo computational avancé, écran OLED 6.2", Android 14 pur.',
                'price' => 699.99,
                'stock' => 15,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=400&h=300&fit=crop'
            ],

            // Electronics - Audio
            [
                'name' => 'AirPods Pro 2',
                'description' => 'Écouteurs sans fil avec réduction de bruit active, son spatial personnalisé, jusqu\'à 6h d\'écoute avec étui de charge.',
                'price' => 249.99,
                'stock' => 35,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Casque Sony WH-1000XM5',
                'description' => 'Casque audio sans fil premium avec réduction de bruit leader du marché, autonomie 30h, certification Hi-Res Audio.',
                'price' => 399.99,
                'stock' => 18,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'JBL Charge 5',
                'description' => 'Enceinte Bluetooth portable étanche IP67, autonomie 20h, fonction powerbank pour recharger vos appareils.',
                'price' => 149.99,
                'stock' => 40,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop'
            ],

            // Furniture - Bureau
            [
                'name' => 'Chaise Herman Miller Aeron',
                'description' => 'Chaise de bureau ergonomique iconique avec support lombaire réglable, accoudoirs 8D, garantie 12 ans. Taille B.',
                'price' => 1395.99,
                'stock' => 5,
                'category' => 'Furniture',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Bureau assis-debout IKEA',
                'description' => 'Bureau réglable en hauteur électrique 120x80cm, plateau blanc, pieds noirs. Mémorisation de 4 positions.',
                'price' => 449.99,
                'stock' => 8,
                'category' => 'Furniture',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Chaise gaming Secretlab',
                'description' => 'Chaise gaming ergonomique avec mousse à mémoire de forme, support lombaire intégré, accoudoirs 4D.',
                'price' => 389.99,
                'stock' => 12,
                'category' => 'Furniture',
                'image' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=400&h=300&fit=crop'
            ],

            // Furniture - Salon
            [
                'name' => 'Canapé modulable IKEA',
                'description' => 'Canapé 3 places modulable avec méridienne, revêtement tissu lavable, coussins réversibles. Livré avec garantie 10 ans.',
                'price' => 799.99,
                'stock' => 6,
                'category' => 'Furniture',
                'image' => 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Table basse design',
                'description' => 'Table basse ronde en chêne massif avec pieds en métal noir, diamètre 90cm, finition huile naturelle.',
                'price' => 299.99,
                'stock' => 10,
                'category' => 'Furniture',
                'image' => 'https://images.unsplash.com/photo-1549497538-303791108f95?w=400&h=300&fit=crop'
            ],

            // Books - Programmation
            [
                'name' => 'Clean Code',
                'description' => 'Un manuel d\'artisanat logiciel par Robert C. Martin. Apprenez à écrire du code propre et maintenable.',
                'price' => 49.99,
                'stock' => 25,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Design Patterns',
                'description' => 'Éléments de logiciels orientés objet réutilisables. Le livre de référence par le Gang of Four.',
                'price' => 54.99,
                'stock' => 20,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'JavaScript: The Good Parts',
                'description' => 'Guide essentiel de JavaScript par Douglas Crockford. Découvrez les bonnes pratiques du langage.',
                'price' => 39.99,
                'stock' => 30,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Symfony 7 - Développez des applications web',
                'description' => 'Guide complet pour maîtriser Symfony 7, des bases aux concepts avancés. Avec projets pratiques.',
                'price' => 45.99,
                'stock' => 15,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop'
            ],

            // Clothing - Mode
            [
                'name' => 'T-shirt développeur "Hello World"',
                'description' => 'T-shirt 100% coton bio avec impression "Hello World" en plusieurs langages de programmation. Coupe unisexe.',
                'price' => 24.99,
                'stock' => 50,
                'category' => 'Clothing',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Hoodie "Code & Coffee"',
                'description' => 'Sweat à capuche premium avec poche kangourou, impression "Powered by Coffee & Code". Matière douce et chaude.',
                'price' => 59.99,
                'stock' => 30,
                'category' => 'Clothing',
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Casquette "Git Commit"',
                'description' => 'Casquette ajustable avec broderie "git commit -m \'styled\'". 100% coton, visière incurvée.',
                'price' => 19.99,
                'stock' => 40,
                'category' => 'Clothing',
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400&h=300&fit=crop'
            ],

            // Home & Garden
            [
                'name' => 'Plante Monstera Deliciosa',
                'description' => 'Plante d\'intérieur tropicale avec feuilles fenêtrées, pot en céramique inclus. Facile d\'entretien, purifie l\'air.',
                'price' => 34.99,
                'stock' => 20,
                'category' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1463154545680-d59320fd685d?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Lampe de bureau LED',
                'description' => 'Lampe LED avec bras articulé, 3 modes d\'éclairage, port USB pour recharge, minuteur automatique.',
                'price' => 89.99,
                'stock' => 25,
                'category' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Diffuseur d\'huiles essentielles',
                'description' => 'Diffuseur ultrasonique 500ml avec 7 couleurs LED, minuteur programmable, arrêt automatique.',
                'price' => 49.99,
                'stock' => 35,
                'category' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=300&fit=crop'
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
        $io->note('Users created: 2 (admin + regular user)');
        $io->note('Products created: ' . count($products));
        $io->note('Categories: Electronics, Furniture, Books, Clothing, Home & Garden');
        $io->table(
            ['Account', 'Email', 'Password'],
            [
                ['Admin', 'admin@example.com', 'admin123'],
                ['User', 'user@example.com', 'user123']
            ]
        );

        return Command::SUCCESS;
    }
}