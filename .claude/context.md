# Contexte du Projet Demo MCP

## Stack Technique
- **Backend**: Laravel 12
- **Frontend**: Vue.js 3 avec Inertia.js
- **Base de données**: SQLite
- **Package MCP**: laravel/mcp v0.3.0

## Objectif
Créer une application de support/FAQ pour démontrer l'utilisation du Model Context Protocol (MCP) de Laravel.

## Architecture Complète

### Backend Laravel
- **Modèle**: `App\Models\Faq` avec scopes pour recherche et filtrage
- **Controller**: `App\Http\Controllers\FaqController` (resource controller)
- **Routes web**: `/faqs` (index, show) + routes protégées pour CRUD
- **Seeder**: 20 FAQs (5 réalistes + 15 aléatoires)

### Serveur MCP
- **Serveur**: `App\Mcp\Servers\FaqServer`
  - Handle local: `faq`
  - Route web: `/mcp/faq`

- **Tools**:
  - `SearchFaqsTool` : Recherche par mots-clés et catégorie
  - `GetFaqCategoriesTool` : Liste des catégories disponibles

- **Resources**:
  - `FaqListResource` (uri: `faqs://all`) : Vue complète des FAQs

### Frontend Vue/Inertia
- `resources/js/pages/Faq/Index.vue` : Liste avec recherche et filtres
- `resources/js/pages/Faq/Show.vue` : Détail d'une FAQ

## Structure Base de Données

Table `faqs`:
- `id` (primary key)
- `question` (string)
- `answer` (text)
- `category` (string, nullable)
- `is_published` (boolean, default: true)
- `view_count` (integer, default: 0)
- `timestamps`

Catégories: Technique, Facturation, Compte, Général, Sécurité

## Commandes Importantes

### MCP
- `php artisan mcp:inspector faq` - Tester le serveur MCP (ouvre localhost:6274)
- `php artisan mcp:start faq` - Démarrer le serveur MCP en mode STDIO

### Développement
- `php artisan migrate:fresh --seed` - Reset DB avec données de test
- `php artisan make:mcp-tool NomTool` - Créer un nouvel outil MCP
- `php artisan make:mcp-resource NomResource` - Créer une ressource MCP

### Routes
- `php artisan vendor:publish --tag=ai-routes` - Publier routes/ai.php

## Documentation MCP Laravel
Référence : https://laravel.com/docs/12.x/mcp

## Notes de Configuration
- Le projet n'utilise PAS Sail pour simplifier la configuration MCP
- Les commandes artisan s'exécutent directement avec `php artisan`
- MCP Inspector crée un proxy local pour tester les outils interactivement
