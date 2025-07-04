# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Architecture

This is a full-stack e-commerce application with a Symfony backend API and Angular frontend. The project uses Docker for containerization and includes comprehensive monitoring and CI/CD setup.

### High-Level Structure
```
├── backend/                 # Symfony API (PHP 8.2+, Symfony 7.0)
│   ├── src/
│   │   ├── Controller/     # API controllers
│   │   ├── Entity/         # Doctrine entities
│   │   ├── Repository/     # Data repositories
│   │   ├── Service/        # Business logic services
│   │   └── Security/       # JWT authentication
│   ├── config/             # Symfony configuration
│   ├── tests/              # PHPUnit tests
│   └── docker/             # Docker configuration
├── frontend/               # Angular application (Angular 17)
│   ├── src/
│   │   ├── app/
│   │   │   ├── components/ # UI components
│   │   │   ├── services/   # Angular services
│   │   │   ├── models/     # TypeScript models
│   │   │   └── guards/     # Route guards
│   │   ├── assets/         # Static resources
│   │   └── environments/   # Environment configs
├── docker-compose.yml      # Docker orchestration
├── Makefile               # Development commands
└── .gitlab-ci.yml         # CI/CD pipeline
```

## Common Development Commands

### Environment Management
```bash
# Start development environment
make dev-start

# Stop development environment
make dev-stop

# View logs
make dev-logs
make dev-logs-backend
make dev-logs-frontend

# Access service shells
make shell-backend
make shell-frontend
make shell-database
```

### Dependencies
```bash
# Install all dependencies
make install

# Install backend dependencies only
make install-backend

# Install frontend dependencies only
make install-frontend
```

### Database Operations
```bash
# Create database
make db-create

# Run migrations
make db-migrate

# Load test data
make db-fixtures

# Reset database completely
make db-reset

# Update schema
make db-schema-update
```

### Testing
```bash
# Run all tests
make test

# Backend tests only
make test-backend

# Frontend tests only
make test-frontend

# Unit tests only
make test-unit

# Integration tests only
make test-integration

# Generate coverage report
make test-coverage
```

### Code Quality
```bash
# Check code style
make lint

# Fix code style issues
make fix
```

## Key Technologies

### Backend (Symfony)
- **Framework**: Symfony 7.0 with API Platform
- **Database**: PostgreSQL 15 with Doctrine ORM
- **Authentication**: JWT with LexikJWTAuthenticationBundle
- **Testing**: PHPUnit with unit and integration test suites
- **Cache**: Redis for session and application caching

### Frontend (Angular)
- **Framework**: Angular 17 with TypeScript
- **UI**: Angular Material and Bootstrap
- **State Management**: NgRx for complex state
- **HTTP**: RxJS for reactive programming
- **Testing**: Jasmine/Karma

### DevOps
- **Containerization**: Docker and Docker Compose
- **Reverse Proxy**: Nginx
- **Monitoring**: Prometheus and Grafana
- **CI/CD**: GitLab CI/CD pipeline

## Service URLs (Development)
- **API Backend**: http://localhost:8000
- **Frontend**: http://localhost:4200
- **API Documentation**: http://localhost:8000/api/doc
- **Grafana**: http://localhost:3000 (admin/admin)
- **Prometheus**: http://localhost:9090

## Database Configuration
- **Host**: localhost:5432
- **Database**: ecommerce
- **User**: ecommerce_user
- **Password**: ecommerce_password (development only)

## Environment Variables
Key environment variables for development:
- `DATABASE_URL`: PostgreSQL connection string
- `JWT_SECRET_KEY`: JWT signing key
- `REDIS_URL`: Redis connection string
- `API_BASE_URL`: Frontend API base URL
- `CORS_ALLOW_ORIGIN`: CORS allowed origins

## Testing Strategy
- **Backend**: PHPUnit with separate unit and integration test suites
- **Frontend**: Jasmine/Karma for unit tests
- **Coverage**: Generated HTML reports available in `coverage/`
- **Test Database**: Separate test database (`ecommerce_test`)

## Development Workflow
1. Use `make dev-start` to spin up the development environment
2. Install dependencies with `make install`
3. Set up database with `make db-create db-migrate db-fixtures`
4. Run tests with `make test` before committing
5. Use `make lint` to check code quality
6. Use `make fix` to automatically fix style issues

## Monitoring and Observability
- **Prometheus**: Metrics collection on port 9090
- **Grafana**: Visualization dashboards on port 3000
- **Health Checks**: Built-in health check endpoints
- **Logging**: Centralized logging with ELK stack (production)

## Security Features
- JWT authentication with refresh tokens
- CORS protection
- Rate limiting on API endpoints
- Input validation on both client and server
- HTTPS enforcement in production
- Database query protection via Doctrine ORM