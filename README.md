# 🛒 E-commerce Full-Stack - Portfolio

> **Projet de démonstration technique** - Application e-commerce complète avec Symfony API et Angular frontend

[![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?style=flat&logo=symfony)](https://symfony.com)
[![Angular](https://img.shields.io/badge/Angular-17-DD0031?style=flat&logo=angular)](https://angular.io)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.2-3178C6?style=flat&logo=typescript)](https://www.typescriptlang.org)
[![Docker](https://img.shields.io/badge/Docker-20.10-2496ED?style=flat&logo=docker)](https://www.docker.com)

## 🎯 Objectif

Démonstration d'expertise **full-stack moderne** avec architecture robuste, sécurité avancée et containerisation Docker.

## ✨ Fonctionnalités

- 🛍️ **Catalogue produits** avec recherche et filtres
- 🛒 **Panier intelligent** avec persistance localStorage
- 🔐 **Authentification JWT** sécurisée
- 📦 **Gestion des commandes** complète
- 📱 **Interface responsive** Material Design
- 🔧 **API REST** documentée

## 🏗️ Stack Technique

### Backend (Symfony 7)
- **API REST** avec API Platform
- **PostgreSQL** + Doctrine ORM
- **JWT Authentication**
- **Redis** pour le cache
- **Validation** multicouche

### Frontend (Angular 17)
- **TypeScript** + RxJS
- **Angular Material** + Bootstrap
- **Reactive Programming**
- **Route Guards** et intercepteurs

### DevOps
- **Docker** containerisation complète
- **Nginx** reverse proxy
- **Multi-stage builds** optimisés
- **Orchestration** multi-services

## 📋 Prérequis

Avant d'installer le projet, assurez-vous d'avoir les outils suivants installés :

- **Docker** (version 20.10+) - [Installation](https://docs.docker.com/get-docker/)
- **Docker Compose** (version 2.0+) - [Installation](https://docs.docker.com/compose/install/)
- **Make** - Généralement préinstallé sur Linux/macOS, [Installation Windows](https://gnuwin32.sourceforge.net/packages/make.htm)
- **Git** - [Installation](https://git-scm.com/downloads)

### Vérification des prérequis
```bash
docker --version          # Docker version 20.10+
docker-compose --version  # Docker Compose version 2.0+
make --version            # GNU Make 4.0+
git --version             # Git 2.0+
```

## 🚀 Installation & Démarrage

```bash
# 1. Cloner le projet
git clone https://github.com/DARDORKE/ecommerce-symfony-angular.git
cd ecommerce-symfony-angular

# 2. Démarrer l'environnement complet
make dev-start

# 3. Installer les dépendances
make install

# 4. Initialiser la base de données
make db-create db-schema-update db-fixtures
```

## 🌐 Accès aux Services

Une fois l'installation terminée, les services sont accessibles aux adresses suivantes :

### 🎯 **Applications Principales**
- **🖥️ Frontend (Interface utilisateur)** : http://localhost:4200
- **🔗 API Backend** : http://localhost:8000
- **📚 Documentation API** : http://localhost:8000/api/doc

### 🔑 **Connexion de Test**
Utilisez ces identifiants pour tester l'application :
- **Email** : `test@example.com`
- **Mot de passe** : `password123`

### 🛠️ **Services de Développement**
- **📊 Base de données PostgreSQL** : `localhost:5432`
    - Database: `ecommerce`
    - User: `ecommerce_user`
    - Password: `ecommerce_password`

### 📱 **Navigation de l'Application**
1. **Page d'accueil** : http://localhost:4200 - Catalogue des produits
2. **Connexion** : http://localhost:4200/login - Authentification utilisateur
3. **Inscription** : http://localhost:4200/register - Création de compte
4. **Panier** : http://localhost:4200/cart - Gestion du panier
5. **Profil** : http://localhost:4200/profile - Informations utilisateur

## 🔧 Commandes Utiles

```bash
make dev-start          # Démarrer tous les services
make dev-stop           # Arrêter l'environnement
make dev-logs           # Voir les logs
make db-reset           # Reset complet BDD
make test               # Exécuter les tests
make shell-backend      # Accès shell backend
make shell-frontend     # Accès shell frontend
```

## 📊 Données de Test

**Compte de démonstration :**
- Email: `test@example.com`
- Password: `password123`

**8 produits** dans différentes catégories (Electronics, Clothing, Books, etc.)

## 🏆 Compétences Démontrées

### 💻 **Développement**
- Architecture RESTful complète
- Authentification JWT sécurisée
- Programmation réactive (RxJS)
- Gestion d'état avancée
- Validation multicouche

### 🔧 **DevOps**
- Containerisation Docker
- Orchestration multi-services
- Configuration environnements
- Automatisation (Makefile)
- Docker Compose optimisé

### 🛡️ **Sécurité**
- JWT tokens avec refresh
- Validation données client/serveur
- Protection CORS
- Hash passwords sécurisé
- Variables d'environnement

## 📈 Services Disponibles

| Service | Port | URL |
|---------|------|-----|
| Frontend | 4200 | http://localhost:4200 |
| API | 8000 | http://localhost:8000 |
| API Doc | 8000 | http://localhost:8000/api/doc |
| Database | 5432 | localhost:5432 |

## 🎯 Architecture

```
📁 ecommerce-symfony-angular/
├── 🚀 backend/           # API Symfony + PostgreSQL
├── 🎨 frontend/          # App Angular + Material
├── 🐳 docker-compose.yml # Orchestration complète
├── 📜 Makefile          # Commandes automatisées
└── 📖 CLAUDE.md         # Documentation développeur
```

## 💡 Points Forts Techniques

- **Symfony 7** avec API Platform pour API REST robuste
- **Angular 17** avec TypeScript et programmation réactive
- **Docker** avec builds multi-stage optimisés
- **JWT** authentification stateless sécurisée
- **PostgreSQL** avec ORM Doctrine et migrations
- **Redis** pour cache haute performance
- **Architecture** clean et maintenable

## 🚀 Évolutions Possibles

- 💳 Intégration paiement (Stripe)
- 📧 Notifications email
- 🔍 Recherche avancée (Elasticsearch)
- 📱 Application mobile (React Native)
- 🌍 Internationalisation
- 📊 Monitoring (Prometheus/Grafana)

---

## 📞 Contact

**Développeur Full-Stack** - Spécialisé en architectures modernes

- 💼 **LinkedIn** : https://www.linkedin.com/in/kevy-dardor/
- 📧 **Email** : contact@kevydardor.dev
- 🐙 **GitHub** : https://github.com/settings/profile
- 🌐 **Portfolio** : https://kevydardor.dev

---

*Projet portfolio démontrant une expertise full-stack moderne* 💻⚡
