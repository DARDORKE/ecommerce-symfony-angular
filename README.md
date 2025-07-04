# 🛒 E-commerce Full-Stack - Portfolio Project

Une application e-commerce complète et fonctionnelle développée avec **Symfony** (API REST) et **Angular** (Frontend moderne). Ce projet démontre une maîtrise complète du développement full-stack avec des technologies modernes et des bonnes pratiques.

## ✨ Fonctionnalités Principales

- 🛍️ **Catalogue produits** avec recherche et filtres par catégorie
- 🛒 **Panier d'achat** intelligent avec gestion des quantités
- 🔐 **Authentification sécurisée** (inscription/connexion JWT)
- 📦 **Gestion des commandes** avec suivi des statuts
- 💳 **Processus de commande** complet et sécurisé
- 📱 **Interface responsive** adaptée à tous les écrans
- 🚀 **API REST** complète et documentée
- 📊 **Monitoring** en temps réel avec Grafana/Prometheus

## 🎯 Démonstration Live

- **🌐 Frontend** : http://localhost:4200
- **🔗 API Backend** : http://localhost:8000
- **📖 Documentation API** : http://localhost:8000/api/doc

### 👤 Compte de démonstration
```
Email: test@example.com
Mot de passe: password123
```

## 🏗️ Architecture Technique

### Backend - API REST (Symfony 7)
- **🐘 PHP 8.2+** avec les dernières fonctionnalités
- **🎯 Symfony 7.0** Framework robuste et moderne
- **🗃️ PostgreSQL 15** Base de données relationnelle
- **🔑 JWT Authentication** Authentification stateless sécurisée
- **📋 Doctrine ORM** Mapping objet-relationnel
- **🛡️ Security Voters** Contrôle d'accès granulaire
- **✅ Validation** Validation complète des données
- **📦 Serialization** API JSON optimisée

### Frontend - SPA (Angular 17)
- **🅰️ Angular 17** Framework moderne avec signals
- **📱 Angular Material** Design system Material
- **🎨 Bootstrap 5** Framework CSS responsive
- **🔄 RxJS** Programmation réactive
- **📡 HTTP Client** Communication API optimisée
- **🛡️ Route Guards** Protection des routes
- **💾 Local Storage** Persistance du panier
- **🎭 Interceptors** Gestion centralisée des requêtes

### Infrastructure & DevOps
- **🐳 Docker & Docker Compose** Containerisation complète
- **🔄 Nginx** Reverse proxy et serveur web
- **🚀 Redis** Cache et sessions
- **📊 Prometheus** Collecte de métriques
- **📈 Grafana** Tableaux de bord et alertes
- **⚡ Makefile** Automatisation des tâches
- **🔧 Multi-stage builds** Optimisation des images

## 🚀 Installation & Démarrage

### 📋 Prérequis
- Docker & Docker Compose
- Git
- Make (optionnel, pour les commandes simplifiées)

### ⚡ Démarrage ultra-rapide

#### Option 1 : Avec Make (Recommandé)
```bash
# 1. Cloner le projet
git clone <your-repo-url>
cd ecommerce-symfony-angular

# 2. Démarrer l'environnement complet
make dev-start

# 3. Installer les dépendances
make install

# 4. Initialiser la base de données
make db-create
make db-schema-update
make db-fixtures

# ✅ L'application est prête !
# Frontend: http://localhost:4200
# Backend API: http://localhost:8000
```

#### Option 2 : Avec Docker Compose
```bash
# 1. Cloner le projet
git clone <your-repo-url>
cd ecommerce-symfony-angular

# 2. Construire et démarrer les services
docker-compose build
docker-compose up -d

# 3. Installer les dépendances backend
docker-compose exec -T backend composer install

# 4. Installer les dépendances frontend
docker-compose exec -T frontend npm install

# 5. Initialiser la base de données
docker-compose exec -T backend php bin/console doctrine:database:create --if-not-exists
docker-compose exec -T backend php bin/console doctrine:schema:update --force
docker-compose exec -T backend php bin/console doctrine:fixtures:load --no-interaction

# ✅ L'application est prête !
```

### 🔧 Vérification de l'installation

```bash
# Vérifier le statut des services
docker-compose ps

# Tester l'API backend
curl http://localhost:8000/api/products

# Tester le frontend
curl http://localhost:4200

# Voir les logs en cas de problème
make dev-logs  # ou docker-compose logs -f
```

## 📊 Données de Démonstration

Le projet inclut **8 produits variés** dans différentes catégories :
- 📱 **Electronics** : MacBook Pro, iPhone 15 Pro, AirPods Pro
- 👕 **Clothing** : T-shirt Nike, Chaussures Adidas
- 📚 **Books** : Le Seigneur des Anneaux
- 🏡 **Home & Garden** : Plante Monstera
- ⚽ **Sports** : Ballon de Football Nike

### 🔄 Gestion de l'environnement
```bash
make dev-start           # Démarrer tous les services
make dev-stop            # Arrêter l'environnement
make dev-restart         # Redémarrer l'environnement
make dev-logs            # Voir tous les logs
make dev-logs-backend    # Logs du backend uniquement
make dev-logs-frontend   # Logs du frontend uniquement
```

### 🗄️ Base de données
```bash
make db-create           # Créer la base de données
make db-migrate          # Exécuter les migrations
make db-fixtures         # Charger les données de test
make db-reset            # Reset complet de la BDD
make db-schema-update    # Mettre à jour le schéma
```

### 🐚 Accès aux conteneurs
```bash
make shell-backend       # Shell dans le conteneur Symfony
make shell-frontend      # Shell dans le conteneur Angular
make shell-database      # Shell PostgreSQL
```

### 🧪 Tests et qualité de code
```bash
make test                # Exécuter tous les tests
make test-backend        # Tests backend uniquement
make test-frontend       # Tests frontend uniquement
make lint                # Vérifier la qualité du code
make fix                 # Corriger automatiquement le code
```

### 📊 Statut et logs
```bash
make dev-logs            # Voir tous les logs
make dev-logs-backend    # Logs backend uniquement
make dev-logs-frontend   # Logs frontend uniquement
docker-compose ps        # Statut des services
```

## 🏗️ Structure du Projet

```
📁 ecommerce-symfony-angular/
├── 🚀 backend/                    # API Symfony
│   ├── 📁 src/
│   │   ├── 🎮 Controller/         # Contrôleurs API REST
│   │   ├── 📊 Entity/             # Entités Doctrine
│   │   ├── 🗃️ Repository/         # Repositories de données
│   │   ├── ⚙️ Service/            # Services métier
│   │   ├── 🛡️ Security/           # Sécurité et authentification
│   │   └── 📦 DataFixtures/       # Données de test
│   ├── ⚙️ config/                 # Configuration Symfony
│   ├── 🧪 tests/                  # Tests PHPUnit
│   └── 🐳 Dockerfile             # Image Docker backend
├── 🎨 frontend/                   # Application Angular
│   ├── 📁 src/app/
│   │   ├── 🧩 components/         # Composants UI
│   │   ├── 🔧 services/           # Services Angular
│   │   ├── 📋 models/             # Modèles TypeScript
│   │   ├── 🛡️ guards/             # Guards de protection
│   │   └── 🔌 interceptors/       # Intercepteurs HTTP
│   ├── 🎯 assets/                 # Ressources statiques
│   ├── 🌍 environments/           # Configurations d'environnement
│   └── 🐳 Dockerfile             # Image Docker frontend
├── 🐳 docker-compose.yml         # Orchestration complète
├── 📜 Makefile                   # Commandes automatisées
├── 🚀 init.sh                    # Script d'initialisation
└── 📖 CLAUDE.md                  # Documentation développeur
```

## 🌐 Services Docker

| Service | Port | URL | Description |
|---------|------|-----|-------------|
| 🎨 **Frontend** | 4200 | http://localhost:4200 | Application Angular |
| 🚀 **Backend** | 8000 | http://localhost:8000 | API Symfony |
| 🗃️ **Database** | 5432 | localhost:5432 | PostgreSQL 15 |
| 🚀 **Redis** | 6379 | localhost:6379 | Cache et sessions |
| 🔄 **Nginx** | 80 | http://localhost | Reverse proxy |

## 🔧 Configuration

### Variables d'environnement Backend
```env
# Configuration de la base de données
DATABASE_URL=postgresql://admin:admins123@database:5432/ecommerce

# Clé secrète JWT (générée automatiquement)
JWT_SECRET_KEY=2bdce6f55f8600b596db3afe1f225855ea7271e020a84dbefb4a939fdac5eefe

# Configuration Redis
REDIS_URL=redis://redis:6379

# Configuration CORS
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$

# Clé secrète de l'application
APP_SECRET=97db9ab9d58f2f62d0ff29b6ea7ff2a8d64f750a60c8d6422aae6103889abb7a
```

### Configuration Frontend
```typescript
environment = {
  production: false,
  apiUrl: 'http://localhost:8000/api'
}
```

## 📊 Fonctionnalités Détaillées

### 🛍️ Gestion des Produits
- ✅ Liste des produits avec pagination
- 🔍 Recherche par nom/description
- 🏷️ Filtrage par catégorie
- 📱 Affichage responsive en grille
- 🖼️ Images produits optimisées
- 📊 Gestion du stock en temps réel

### 🛒 Panier d'Achat
- ➕ Ajout/suppression de produits
- 🔢 Modification des quantités
- 💾 Persistance en localStorage
- 🧮 Calcul automatique des totaux
- ⚠️ Vérification du stock disponible

### 🔐 Authentification
- 📝 Inscription avec validation
- 🔑 Connexion sécurisée JWT
- 🛡️ Protection des routes sensibles
- 👤 Gestion du profil utilisateur
- 🚪 Déconnexion automatique

### 📦 Gestion des Commandes
- 🛒 Création de commande depuis le panier
- 📋 Historique des commandes
- 🔄 Suivi des statuts (pending, confirmed, shipped, delivered)
- 📧 Références uniques de commande
- 💰 Calcul automatique des totaux

## 🔒 Sécurité

- 🔐 **JWT Authentication** avec tokens sécurisés
- 🛡️ **CORS** configuré pour la production
- ✅ **Validation** côté client et serveur
- 🔒 **Hachage des mots de passe** avec Symfony
- 🚫 **Protection XSS** et injection SQL
- 🔐 **Variables d'environnement** pour les secrets

## 📈 Performance & Monitoring

- ⚡ **Cache Redis** pour les sessions
- 📊 **Métriques Prometheus** pour le monitoring
- 📈 **Dashboards Grafana** pour la visualisation
- 🚀 **Images Docker optimisées**
- 📦 **Build multi-stage** pour la production
- 🔍 **Health checks** automatiques

## 🎯 Objectifs du Portfolio

Ce projet démontre :
- 💼 **Full-Stack Development** complet
- 🏗️ **Architecture moderne** et scalable
- 🔧 **DevOps et containerisation** avec Docker
- 📊 **Monitoring et observabilité**
- 🛡️ **Sécurité** et bonnes pratiques
- 🧪 **Tests** et qualité du code
- 📖 **Documentation** complète

## 🚀 Évolutions Futures

- 💳 Intégration paiement (Stripe/PayPal)
- 📧 Notifications email
- 📱 Application mobile (Ionic/React Native)
- 🤖 API GraphQL
- 🌍 Internationalisation (i18n)
- 📊 Analytics avancées
- 🔍 Recherche elasticsearch

---

## 📞 Contact

**Portfolio E-commerce** - Démonstration de compétences Full-Stack

Pour toute question sur ce projet portfolio :
- 💼 **LinkedIn** : [Votre profil LinkedIn]
- 📧 **Email** : [votre.email@example.com]
- 🐙 **GitHub** : [Votre profil GitHub]

---

*Développé avec passion pour démontrer des compétences full-stack modernes* 💻✨
