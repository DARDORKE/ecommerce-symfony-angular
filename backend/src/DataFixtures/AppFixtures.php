<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Créer un utilisateur de test
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);

        // Créer des produits de test
        $products = [
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'MacBook Pro 14 pouces avec puce M3 Pro, 18 Go de mémoire unifiée et SSD de 512 Go.',
                'price' => '2499.00',
                'category' => 'Electronics',
                'stock' => 10,
                'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp14-spacegray-select-202310?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1697311054290'
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'iPhone 15 Pro avec puce A17 Pro, caméra 48 Mpx et écran Super Retina XDR.',
                'price' => '1229.00',
                'category' => 'Electronics',
                'stock' => 25,
                'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1693009279896'
            ],
            [
                'name' => 'AirPods Pro 2',
                'description' => 'AirPods Pro de 2e génération avec réduction de bruit active et Audio spatial.',
                'price' => '279.00',
                'category' => 'Electronics',
                'stock' => 50,
                'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=1660803972361'
            ],
            [
                'name' => 'T-shirt Nike Sportswear',
                'description' => 'T-shirt en coton doux avec logo Nike classique. Coupe décontractée.',
                'price' => '29.99',
                'category' => 'Clothing',
                'stock' => 100,
                'image' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/tee-shirt-sportswear-pour-homme-Df0642.png'
            ],
            [
                'name' => 'Chaussures Adidas Ultraboost',
                'description' => 'Chaussures de running avec technologie Boost pour un confort optimal.',
                'price' => '179.95',
                'category' => 'Clothing',
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
            ],
            [
                'name' => 'Le Seigneur des Anneaux',
                'description' => 'Trilogie complète de J.R.R. Tolkien en édition collector.',
                'price' => '45.00',
                'category' => 'Books',
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
            ],
            [
                'name' => 'Plante Monstera Deliciosa',
                'description' => 'Belle plante d\'intérieur avec feuilles découpées. Parfaite pour décorer votre salon.',
                'price' => '39.99',
                'category' => 'Home & Garden',
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
            ],
            [
                'name' => 'Ballon de Football Nike',
                'description' => 'Ballon de football officiel avec technologie Aerowsculpt pour une trajectoire précise.',
                'price' => '24.99',
                'category' => 'Sports',
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
            ]
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            $product->setCategory($productData['category']);
            $product->setStock($productData['stock']);
            $product->setImage($productData['image']);
            $product->setActive(true);
            
            $manager->persist($product);
        }

        $manager->flush();
    }
}