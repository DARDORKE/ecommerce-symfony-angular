# Déploiement Frontend sur Vercel

## 🚀 Guide étape par étape

### 1. **Prérequis**
- Compte Vercel : https://vercel.com
- Projet connecté à GitHub
- Backend Railway déployé et fonctionnel

### 2. **Déploiement via l'interface Vercel**

#### A. Connexion à Vercel
1. Allez sur https://vercel.com
2. Connectez-vous avec votre compte GitHub
3. Cliquez sur "New Project"

#### B. Configuration du projet
1. **Sélectionnez votre repository** GitHub
2. **Framework Preset** : Sélectionnez "Angular"
3. **Root Directory** : `frontend`
4. **Build Command** : `npm run build`
5. **Output Directory** : `dist/ecommerce-frontend`
6. **Install Command** : `npm ci`

#### C. Variables d'environnement
Dans les paramètres Vercel, ajoutez :
- `NODE_ENV=production`

### 3. **URLs de l'application**

#### Backend (Railway)
- **API** : https://ecommerce-symfony-angular-production.up.railway.app
- **Health** : https://ecommerce-symfony-angular-production.up.railway.app/api/health
- **Products** : https://ecommerce-symfony-angular-production.up.railway.app/api/products

#### Frontend (Vercel)
- **App** : https://votre-projet.vercel.app

### 4. **Configuration locale**

#### Build local pour test
```bash
cd frontend
npm ci
npm run build:prod
```

#### Test du build local
```bash
cd frontend/dist/ecommerce-frontend
python -m http.server 8080
# Ou
npx http-server -p 8080
```

### 5. **Structure des fichiers de configuration**

```
frontend/
├── vercel.json           # Configuration Vercel
├── .vercelignore        # Fichiers à ignorer
├── src/
│   └── environments/
│       ├── environment.ts      # Développement
│       └── environment.prod.ts # Production (Railway API)
└── package.json         # Scripts de build
```

### 6. **Vérifications après déploiement**

#### A. Tests basiques
- [ ] L'application charge sans erreur
- [ ] La page d'accueil s'affiche
- [ ] Le routage fonctionne (navigation)

#### B. Tests API
- [ ] Liste des produits se charge
- [ ] Authentification fonctionne
- [ ] CORS configuré correctement

#### C. Tests performance
- [ ] Temps de chargement < 3s
- [ ] Build size raisonnable
- [ ] Cache statique configuré

### 7. **Dépannage courant**

#### Erreur CORS
Si vous avez des erreurs CORS, vérifiez dans Railway que `CORS_ALLOW_ORIGIN` inclut votre domaine Vercel :
```
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1|.*\.vercel\.app|.*\.railway\.app)(:[0-9]+)?$
```

#### Erreur 404 sur les routes
Vérifiez que `vercel.json` contient la redirection vers `index.html`.

#### Build qui échoue
Vérifiez que toutes les dépendances sont dans `package.json` et non en devDependencies.

### 8. **Optimisations**

#### A. Performance
- **Lazy loading** des modules
- **Tree shaking** automatique avec production build
- **Compression** gzip/brotli par Vercel

#### B. SEO (optionnel)
- Ajout de meta tags
- Open Graph pour partage social
- Schema.org pour produits

### 9. **Commandes utiles**

```bash
# Build de production local
npm run build:prod

# Analyse du bundle
npx webpack-bundle-analyzer dist/ecommerce-frontend/stats.json

# Test des performances
npm install -g lighthouse
lighthouse https://votre-app.vercel.app
```

### 10. **Prochaines étapes**
Une fois déployé :
1. Tester toutes les fonctionnalités
2. Configurer un nom de domaine personnalisé (optionnel)
3. Mettre en place le monitoring d'erreurs
4. Configurer les analytics