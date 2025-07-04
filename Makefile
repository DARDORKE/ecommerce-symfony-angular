# E-commerce Symfony Angular Project Makefile

.PHONY: help dev-start dev-stop dev-logs install test lint fix

# Default target
help:
	@echo "Available commands:"
	@echo "  make dev-start       - Start development environment"
	@echo "  make dev-stop        - Stop development environment"
	@echo "  make dev-logs        - View all logs"
	@echo "  make dev-logs-backend - View backend logs"
	@echo "  make dev-logs-frontend - View frontend logs"
	@echo "  make install         - Install all dependencies"
	@echo "  make install-backend - Install backend dependencies"
	@echo "  make install-frontend - Install frontend dependencies"
	@echo "  make db-create       - Create database"
	@echo "  make db-migrate      - Run database migrations"
	@echo "  make db-fixtures     - Load test data"
	@echo "  make db-reset        - Reset database completely"
	@echo "  make db-schema-update - Update database schema"
	@echo "  make test            - Run all tests"
	@echo "  make test-backend    - Run backend tests"
	@echo "  make test-frontend   - Run frontend tests"
	@echo "  make test-unit       - Run unit tests"
	@echo "  make test-integration - Run integration tests"
	@echo "  make test-coverage   - Generate test coverage report"
	@echo "  make lint            - Check code style"
	@echo "  make fix             - Fix code style issues"
	@echo "  make shell-backend   - Access backend shell"
	@echo "  make shell-frontend  - Access frontend shell"
	@echo "  make shell-database  - Access database shell"

# Development Environment
dev-start:
	docker-compose up -d

dev-stop:
	docker-compose down

dev-logs:
	docker-compose logs -f

dev-logs-backend:
	docker-compose logs -f backend

dev-logs-frontend:
	docker-compose logs -f frontend

# Installation
install: install-backend install-frontend

install-backend:
	docker-compose exec backend composer install

install-frontend:
	docker-compose exec frontend npm install

# Database Operations
db-create:
	docker-compose exec backend php bin/console doctrine:database:create --if-not-exists

db-migrate:
	docker-compose exec backend php bin/console doctrine:migrations:migrate --no-interaction

db-fixtures:
	docker-compose exec backend php bin/console doctrine:fixtures:load --no-interaction

db-reset: db-drop db-create db-migrate db-fixtures

db-drop:
	docker-compose exec backend php bin/console doctrine:database:drop --force --if-exists

db-schema-update:
	docker-compose exec backend php bin/console doctrine:schema:update --force

# Testing
test: test-backend test-frontend

test-backend:
	docker-compose exec backend php bin/phpunit

test-frontend:
	docker-compose exec frontend npm test

test-unit:
	docker-compose exec backend php bin/phpunit --testsuite=unit

test-integration:
	docker-compose exec backend php bin/phpunit --testsuite=integration

test-coverage:
	docker-compose exec backend php bin/phpunit --coverage-html coverage/

# Code Quality
lint:
	docker-compose exec backend ./vendor/bin/php-cs-fixer fix --dry-run --diff
	docker-compose exec frontend npm run lint

fix:
	docker-compose exec backend ./vendor/bin/php-cs-fixer fix
	docker-compose exec frontend npm run lint:fix

# Shell Access
shell-backend:
	docker-compose exec backend bash

shell-frontend:
	docker-compose exec frontend sh

shell-database:
	docker-compose exec database psql -U admin -d ecommerce

# Build and Deploy
build:
	docker-compose build

clean:
	docker-compose down -v
	docker system prune -f