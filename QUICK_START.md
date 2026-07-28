# 🚀 Quick Start - Demo MCP

## Installation (5 minutes)

```bash
# 1. Installer les dépendances
composer install
yarn install --frozen-lockfile

# 2. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 3. Créer la base de données avec données de test
php artisan migrate:fresh --seed

# 4. Compiler les assets (optionnel pour le web)
yarn build
```

## ✅ Tester le serveur MCP

### Option 1 : MCP Inspector (Recommandé pour la démo)

```bash
php artisan mcp:inspector faq
```

➜ Ouvre automatiquement l'interface web sur `http://localhost:6274`

**Dans l'inspector, vous pouvez :**
- ✨ Voir tous les outils disponibles (search_faqs, get_faq_categories)
- 🔍 Tester les outils avec des paramètres personnalisés
- 📚 Accéder aux ressources (faqs://all)
- 🧪 Simuler un client MCP

### Option 2 : Claude Desktop

```bash
# Configuration automatique
./setup-claude-desktop.sh
```

Puis redémarrez Claude Desktop et testez :
- "Liste les catégories de FAQ"
- "Recherche des FAQs sur le mot de passe"

## 🎯 Ce que fait ce projet

### Pour les utilisateurs (interface web)
- Accès aux FAQs sur `/faqs`
- Recherche et filtrage par catégorie
- Statistiques de vues

### Pour les IA (via MCP)
- **Tool `search_faqs`** : Recherche intelligente dans les FAQs
- **Tool `get_faq_categories`** : Liste des catégories
- **Resource `faqs://all`** : Base de connaissances complète

## 📊 Données de test incluses

- **5 FAQs réalistes** :
  - Comment réinitialiser mon mot de passe ?
  - Quels sont les modes de paiement acceptés ?
  - Comment contacter le support technique ?
  - L'application est-elle sécurisée ?
  - Puis-je exporter mes données ?

- **15 FAQs aléatoires** générées automatiquement

- **5 Catégories** :
  - Technique
  - Facturation
  - Compte
  - Général
  - Sécurité

## 🎬 Scénario de démonstration

### 1. Montrer l'interface web
```bash
php artisan serve
# Visitez http://localhost:8000/faqs
```

### 2. Montrer le MCP Inspector
```bash
php artisan mcp:inspector faq
```

**Démo des tools :**
- Tester `get_faq_categories` (sans paramètres)
- Tester `search_faqs` avec `{"query": "mot de passe"}`
- Tester `search_faqs` avec `{"category": "Compte"}`

**Démo des resources :**
- Charger `faqs://all` pour voir toute la base

### 3. Montrer l'intégration Claude Desktop
- Ouvrir Claude Desktop
- Poser la question : "Peux-tu me lister toutes les catégories de FAQ ?"
- Poser la question : "Recherche dans les FAQs comment réinitialiser un mot de passe"
- Observer comment Claude utilise les tools MCP en arrière-plan

## 🔑 Points clés à expliquer

1. **MCP = Protocole standardisé** pour que les IA accèdent à des données
2. **Tools** = Actions que l'IA peut exécuter
3. **Resources** = Données que l'IA peut lire
4. **Serveur Local** = Pour développement/test (via artisan)
5. **Serveur Web** = Pour production (via HTTP)

## 📁 Fichiers importants

```
routes/ai.php                   # Configuration des serveurs MCP
app/Mcp/Servers/FaqServer.php   # Définition du serveur
app/Mcp/Tools/                  # Outils MCP
app/Mcp/Resources/              # Ressources MCP
```

## 🎓 Aller plus loin

### Ajouter un nouveau tool
```bash
php artisan make:mcp-tool MonTool
```

### Ajouter une resource
```bash
php artisan make:mcp-resource MaResource
```

### Créer un nouveau serveur
```bash
php artisan make:mcp-server MonServeur
```

## 🐛 Problèmes courants

**Le serveur ne démarre pas ?**
```bash
# Vérifiez PHP
php --version

# Vérifiez la base de données
php artisan migrate:status
```

**Claude Desktop ne voit pas le serveur ?**
- Vérifiez le chemin absolu dans la config
- Redémarrez complètement Claude Desktop
- Consultez les Developer Tools (View > Developer)

## 📚 Documentation complète

- [README.md](./README.md) - Documentation complète
- [CLAUDE_DESKTOP_SETUP.md](./CLAUDE_DESKTOP_SETUP.md) - Setup Claude Desktop
- [Laravel MCP Docs](https://laravel.com/docs/12.x/mcp)
