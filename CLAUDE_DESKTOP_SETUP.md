# Configuration Claude Desktop pour Demo MCP

## 📋 Prérequis

- Claude Desktop installé
- PHP installé et accessible dans le PATH
- Le projet demo-mcp configuré et fonctionnel

## 🔧 Configuration

### 1. Localiser le fichier de configuration Claude Desktop

Le fichier de configuration se trouve à :

**macOS** :
```
~/Library/Application Support/Claude/claude_desktop_config.json
```

**Windows** :
```
%APPDATA%\Claude\claude_desktop_config.json
```

**Linux** :
```
~/.config/Claude/claude_desktop_config.json
```

### 2. Ajouter le serveur MCP FAQ

Ouvrez le fichier `claude_desktop_config.json` et ajoutez la configuration suivante :

```json
{
  "mcpServers": {
    "demo-faq": {
      "command": "php",
      "args": [
        "/Users/benjamin-roma-sacconney/projects/demo-mcp/artisan",
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

**⚠️ Important** : Remplacez `/Users/benjamin-roma-sacconney/projects/demo-mcp` par le chemin ABSOLU vers votre projet.

### 3. Si vous avez déjà d'autres serveurs MCP

Ajoutez simplement le serveur `demo-faq` à la liste existante :

```json
{
  "mcpServers": {
    "existing-server": {
      "command": "node",
      "args": ["path/to/server.js"]
    },
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

### 4. Redémarrer Claude Desktop

Fermez complètement Claude Desktop et relancez-le pour charger la nouvelle configuration.

## ✅ Vérification

Une fois Claude Desktop redémarré, vous devriez voir :

1. **Dans l'interface Claude** : Une icône ou mention indiquant que des serveurs MCP sont connectés
2. **Dans les outils disponibles** : Les tools `search_faqs` et `get_faq_categories`
3. **Dans les ressources** : La ressource `faqs://all`

## 🧪 Test

Essayez ces commandes dans Claude Desktop :

```
Peux-tu me lister toutes les catégories de FAQ disponibles ?
```

```
Recherche des FAQs sur le mot de passe
```

```
Montre-moi toutes les FAQs de la catégorie "Compte"
```

```
Accède à la ressource faqs://all et résume les questions les plus consultées
```

## 🐛 Dépannage

### Le serveur ne se connecte pas

**Vérifiez** :
1. Le chemin absolu vers `artisan` est correct
2. PHP est accessible en ligne de commande : `php --version`
3. La base de données est bien créée : `php artisan migrate:fresh --seed`
4. Les logs de Claude Desktop (Menu > View > Developer > Toggle Developer Tools)

### Commandes PHP ne fonctionnent pas

Si `php` n'est pas dans le PATH, utilisez le chemin complet :

**macOS (Homebrew)** :
```json
"command": "/opt/homebrew/bin/php"
```

**macOS (MAMP)** :
```json
"command": "/Applications/MAMP/bin/php/php8.3.0/bin/php"
```

**Windows** :
```json
"command": "C:\\php\\php.exe"
```

### Variable d'environnement DB

Si vous utilisez une base de données autre que SQLite, ajoutez les variables :

```json
{
  "mcpServers": {
    "demo-faq": {
      "command": "php",
      "args": [
        "/chemin/vers/artisan",
        "mcp:start",
        "faq"
      ],
      "env": {
        "APP_ENV": "local",
        "DB_CONNECTION": "mysql",
        "DB_HOST": "127.0.0.1",
        "DB_PORT": "3306",
        "DB_DATABASE": "demo_mcp",
        "DB_USERNAME": "root",
        "DB_PASSWORD": "password"
      }
    }
  }
}
```

## 📚 Ressources

- [Documentation Laravel MCP](https://laravel.com/docs/12.x/mcp)
- [Model Context Protocol](https://modelcontextprotocol.io/)
- [Claude Desktop Documentation](https://claude.ai/desktop)

## 💡 Prochaines étapes

Une fois configuré, vous pouvez :
- Créer de nouvelles FAQs via l'interface web
- Les interroger via Claude Desktop
- Démontrer comment une IA peut interagir avec votre base de connaissances
- Étendre le serveur MCP avec de nouveaux outils
