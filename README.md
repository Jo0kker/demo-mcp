# Demo MCP - Application FAQ avec Laravel MCP

Une application de démonstration qui illustre l'utilisation du **Model Context Protocol (MCP)** de Laravel pour exposer une base de connaissances FAQ à des clients MCP comme Claude.

## 🎯 Objectif

Ce projet démontre comment utiliser Laravel MCP pour créer un serveur qui expose :
- **Tools** : Outils pour rechercher et filtrer des FAQs
- **Resources** : Accès à la base de connaissances complète
- Une interface web pour gérer les FAQs

## 🚀 Stack Technique

- **Backend** : Laravel 12
- **Frontend** : Vue.js 3 + Inertia.js
- **Base de données** : SQLite
- **MCP** : Laravel MCP (`laravel/mcp`)

## 📦 Installation

### 1. Cloner et installer les dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances NPM
npm install

# Copier le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 2. Configurer la base de données

```bash
# Créer la base de données et exécuter les migrations avec données de test
php artisan migrate:fresh --seed
```

### 3. Compiler les assets

```bash
# En développement
npm run dev

# Pour la production
npm run build
```

## 🧪 Tester le serveur MCP

### Avec MCP Inspector

La méthode la plus simple pour tester le serveur MCP :

```bash
php artisan mcp:inspector faq
```

Cette commande :
- Lance le serveur MCP en local
- Démarre un proxy sur `localhost:6277`
- Ouvre l'inspecteur web sur `localhost:6274`
- Vous permet de tester interactivement les tools et resources

### Serveurs MCP disponibles

#### Serveur Local
```bash
# Handle: faq
php artisan mcp:start faq
```

#### Serveur Web
Accessible via HTTP sur la route `/mcp/faq`

## 🛠️ Fonctionnalités MCP

### Tools (Outils)

#### 1. `search_faqs`
Recherche dans la base de connaissances FAQ.

**Paramètres :**
- `query` (string) : Texte à rechercher
- `category` (string, optionnel) : Filtrer par catégorie
- `limit` (integer, défaut: 10) : Nombre de résultats

**Exemple d'utilisation :**
```json
{
  "query": "mot de passe",
  "category": "Compte",
  "limit": 5
}
```

#### 2. `get_faq_categories`
Récupère la liste de toutes les catégories disponibles.

**Paramètres :** Aucun

### Resources

#### `faqs://all`
Accès en lecture à la liste complète de toutes les FAQs publiées, organisées par catégorie.

## 📋 Structure du projet MCP

```
app/Mcp/
├── Servers/
│   └── FaqServer.php          # Serveur MCP principal
├── Tools/
│   ├── SearchFaqsTool.php     # Outil de recherche
│   └── GetFaqCategoriesTool.php # Outil pour les catégories
└── Resources/
    └── FaqListResource.php     # Ressource liste des FAQs

routes/
└── ai.php                      # Routes MCP
```

## 🔧 Configuration MCP

Le serveur MCP est configuré dans `routes/ai.php` :

```php
use App\Mcp\Servers\FaqServer;
use Laravel\Mcp\Facades\Mcp;

// Serveur local (via artisan)
Mcp::local('faq', FaqServer::class);

// Serveur web (via HTTP)
Mcp::web('/mcp/faq', FaqServer::class);
```

## 💡 Cas d'usage

### Intégration avec Claude Desktop

#### Configuration automatique (recommandé)

```bash
./setup-claude-desktop.sh
```

Ce script va :
- Détecter automatiquement votre système d'exploitation
- Créer la configuration Claude Desktop
- Sauvegarder votre configuration existante si elle existe

#### Configuration manuelle

Consultez le guide détaillé : [CLAUDE_DESKTOP_SETUP.md](./CLAUDE_DESKTOP_SETUP.md)

**Résumé rapide :**

1. Localisez votre fichier de configuration Claude Desktop :
   - macOS : `~/Library/Application Support/Claude/claude_desktop_config.json`
   - Linux : `~/.config/Claude/claude_desktop_config.json`
   - Windows : `%APPDATA%\Claude\claude_desktop_config.json`

2. Ajoutez cette configuration :

```json
{
  "mcpServers": {
    "demo-faq": {
      "command": "php",
      "args": [
        "/chemin/absolu/vers/demo-mcp/artisan",
        "mcp:start",
        "faq"
      ],
      "env": {
        "APP_ENV": "local"
      }
    }
  }
}
```

3. Redémarrez Claude Desktop

**Testez avec ces questions :**
- "Liste les catégories de FAQ disponibles"
- "Recherche des FAQs sur le mot de passe"
- "Montre-moi les FAQs de la catégorie Compte"

### API pour chatbots

Le serveur web MCP peut être utilisé par :
- Des chatbots de support client
- Des assistants virtuels
- Des intégrations tierces via HTTP

## 📚 Documentation

- [Laravel MCP Documentation](https://laravel.com/docs/12.x/mcp)
- [Model Context Protocol](https://modelcontextprotocol.io/)

## 🧑‍💻 Développement

### Ajouter un nouvel outil MCP

```bash
php artisan make:mcp-tool MonNouveauTool
```

### Ajouter une nouvelle ressource MCP

```bash
php artisan make:mcp-resource MaNouvelleResource
```

### Créer un nouveau serveur MCP

```bash
php artisan make:mcp-server MonServeur
```

## 📝 Notes

- Les FAQs sont créées avec des données de test via le seeder
- 5 FAQs réalistes + 15 FAQs générées aléatoirement
- Catégories : Technique, Facturation, Compte, Général, Sécurité

## 🤝 Contribution

Ce projet est une démonstration. N'hésitez pas à l'utiliser comme base pour vos propres projets MCP !

## 📄 Licence

MIT
