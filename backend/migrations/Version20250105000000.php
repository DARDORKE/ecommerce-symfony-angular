<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database schema for e-commerce application';
    }

    public function up(Schema $schema): void
    {
        // Users table
        $this->addSql('CREATE TABLE users (
            id SERIAL PRIMARY KEY,
            email VARCHAR(180) UNIQUE NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
        )');

        // Products table
        $this->addSql('CREATE TABLE products (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price NUMERIC(10,2) NOT NULL,
            stock INTEGER DEFAULT 0,
            image_url VARCHAR(500),
            category VARCHAR(100),
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
        )');

        // Orders table
        $this->addSql('CREATE TABLE orders (
            id SERIAL PRIMARY KEY,
            user_id INTEGER NOT NULL,
            status VARCHAR(50) DEFAULT \'pending\',
            total_amount NUMERIC(10,2) NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_orders_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )');

        // Order items table
        $this->addSql('CREATE TABLE order_items (
            id SERIAL PRIMARY KEY,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL,
            price NUMERIC(10,2) NOT NULL,
            CONSTRAINT FK_order_items_order_id FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            CONSTRAINT FK_order_items_product_id FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )');

        // Create indexes
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_products_category ON products(category)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_orders_user_id ON orders(user_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items(order_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_order_items_product_id ON order_items(product_id)');

        // Insert a default admin user (password: admin123)
        $this->addSql("INSERT INTO users (email, roles, password, first_name, last_name) VALUES 
            (\'admin@example.com\', \'[\"ROLE_ADMIN\"]\', \'\$2y\$13\$O9gHJFYWQ.0a7YR6FrP8SOKKQh5pJxcU8N5xL3SjLnYjGQQg3N/ca\', \'Admin\', \'User\')");

        // Insert sample products
        $this->addSql("INSERT INTO products (name, description, price, stock, category) VALUES 
            (\'Laptop Dell XPS 13\', \'Laptop haute performance avec écran 13 pouces\', 1299.99, 10, \'Electronics\'),
            (\'iPhone 15 Pro\', \'Smartphone Apple dernière génération\', 999.99, 25, \'Electronics\'),
            (\'Chaise de bureau ergonomique\', \'Chaise confortable pour le travail\', 249.99, 15, \'Furniture\'),
            (\'Casque Bluetooth Sony\', \'Casque audio sans fil haute qualité\', 179.99, 30, \'Electronics\'),
            (\'Livre PHP Moderne\', \'Guide complet pour apprendre PHP\', 39.99, 50, \'Books\')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS order_items');
        $this->addSql('DROP TABLE IF EXISTS orders');
        $this->addSql('DROP TABLE IF EXISTS products');
        $this->addSql('DROP TABLE IF EXISTS users');
    }
}