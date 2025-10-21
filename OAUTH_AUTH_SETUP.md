# 🔐 Authentification OAuth 2.1 pour MCP

## 🎯 Architecture mise en place

Votre serveur MCP FAQ dispose maintenant de **deux modes d'accès** :

### 1. Mode PUBLIC (`/mcp/faq`)
- ✅ Accessible sans authentification
- ✅ Tools disponibles : `search_faqs`, `get_faq_categories`
- ✅ Resources disponibles : `faqs://all`
- ❌ Tool `create_faq` **NON disponible** (masqué via `shouldRegister()`)

### 2. Mode ADMIN (`/mcp/faq/admin`)
- 🔐 Nécessite authentification OAuth 2.1
- ✅ Tous les tools disponibles : `search_faqs`, `get_faq_categories`, `create_faq`
- ✅ Toutes les resources disponibles
- 🎨 Fenêtre d'authentification automatique dans Claude Desktop

## 🚀 Comment ça fonctionne

### Le flux OAuth avec Claude Desktop

1. **Claude Desktop demande** à accéder au serveur MCP
2. **Une fenêtre de navigateur s'ouvre automatiquement** avec la page de connexion
3. **Vous vous connectez** avec vos identifiants Laravel
4. **Vous autorisez l'accès** (comme quand vous connectez une app à Google/Facebook)
5. **Claude Desktop reçoit un token** OAuth valide
6. **Le tool `create_faq` devient disponible** car `Auth::check()` retourne `true`

C'est exactement comme autoriser une application tierce à accéder à votre compte Google !

## 📋 Configuration

### Routes OAuth (déjà configuré)

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;

// Active les routes OAuth pour MCP
Mcp::oauthRoutes();

// Serveur public - consultation seulement
Mcp::web('/mcp/faq', FaqServer::class);

// Serveur admin - avec OAuth
Mcp::web('/mcp/faq/admin', FaqServer::class)
    ->middleware(['auth:api']);
```

### Les routes OAuth créées automatiquement :

- `GET /oauth/authorize` - Page d'autorisation
- `POST /oauth/token` - Échange de code contre token
- `GET /oauth/scopes` - Liste des scopes disponibles
- `GET /oauth/personal-access-tokens` - Gestion des tokens
- `POST /oauth/personal-access-tokens` - Créer un token

## 🔧 Configuration Claude Desktop

### Pour le serveur PUBLIC (pas d'auth)

```json
{
  "mcpServers": {
    "demo-faq-public": {
      "command": "php",
      "args": [
        "/chemin/absolu/vers/demo-mcp/artisan",
        "mcp:start",
        "faq"
      ]
    }
  }
}
```

**Ou via HTTP :**

```json
{
  "mcpServers": {
    "demo-faq-public": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "http://votre-domaine.com/mcp/faq"
      ]
    }
  }
}
```

### Pour le serveur ADMIN (avec OAuth) ⭐

```json
{
  "mcpServers": {
    "demo-faq-admin": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "http://votre-domaine.com/mcp/faq/admin"
      ],
      "oauth": {
        "authorizationUrl": "http://votre-domaine.com/oauth/authorize",
        "tokenUrl": "http://votre-domaine.com/oauth/token",
        "clientId": "VOTRE_CLIENT_ID",
        "clientSecret": "VOTRE_CLIENT_SECRET",
        "scopes": ["*"]
      }
    }
  }
}
```

## 🎫 Obtenir le Client ID et Secret

### Méthode 1 : Via Artisan (recommandé)

```bash
php artisan passport:client --password
```

Vous obtiendrez :
```
Client ID: 9d2a5c4e-1f3b-4e8d-9a2c-5b1e3f4a6d8c
Client secret: abc123def456...
```

### Méthode 2 : Via la base de données

```bash
php artisan tinker
```

```php
>>> use Laravel\Passport\Client;
>>> $client = Client::create([
...     'name' => 'Claude Desktop MCP Client',
...     'secret' => encrypt('generated-secret'),
...     'redirect' => 'http://localhost',
...     'personal_access_client' => false,
...     'password_client' => true,
...     'revoked' => false,
... ]);
>>> echo "Client ID: " . $client->id;
>>> echo "Client Secret: " . $client->plainTextSecret();
```

## 🧪 Tester l'authentification OAuth

### 1. Démarrer le serveur Laravel

```bash
php artisan serve
```

### 2. Tester manuellement le flux OAuth

```bash
# 1. Demander l'autorisation (ouvre le navigateur)
open "http://localhost:8000/oauth/authorize?client_id=VOTRE_CLIENT_ID&redirect_uri=http://localhost&response_type=code&scope=*"

# 2. Après autorisation, vous obtenez un code
# 3. Échanger le code contre un token
curl -X POST http://localhost:8000/oauth/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "authorization_code",
    "client_id": "VOTRE_CLIENT_ID",
    "client_secret": "VOTRE_CLIENT_SECRET",
    "redirect_uri": "http://localhost",
    "code": "LE_CODE_RECU"
  }'
```

### 3. Utiliser le token

```bash
# Appeler le serveur MCP admin avec le token
curl http://localhost:8000/mcp/faq/admin \
  -H "Authorization: Bearer VOTRE_ACCESS_TOKEN" \
  -H "Content-Type: application/json"
```

## 🎨 Personnaliser la page d'autorisation

Pour personnaliser l'interface utilisateur OAuth :

```bash
php artisan vendor:publish --tag=passport-views
```

Les vues seront dans `resources/views/vendor/passport/`

## 📊 Différences entre les deux modes

| Fonctionnalité | Mode PUBLIC | Mode ADMIN (OAuth) |
|---|---|---|
| Recherche FAQs | ✅ | ✅ |
| Liste catégories | ✅ | ✅ |
| Accès ressources | ✅ | ✅ |
| **Créer FAQ** | ❌ | ✅ |
| Authentification requise | ❌ | ✅ |
| Fenêtre d'auth automatique | ❌ | ✅ |

## 🔒 Sécurité

### En production

1. **Utilisez HTTPS obligatoirement**
```env
APP_URL=https://votre-domaine.com
SESSION_SECURE_COOKIE=true
```

2. **Limitez les scopes OAuth**
```php
// app/Providers/AuthServiceProvider.php
use Laravel\Passport\Passport;

public function boot(): void
{
    Passport::tokensCan([
        'faq-read' => 'Lire les FAQs',
        'faq-write' => 'Créer des FAQs',
    ]);
}
```

3. **Configurez l'expiration des tokens**
```php
Passport::tokensExpireIn(now()->addDays(15));
Passport::refreshTokensExpireIn(now()->addDays(30));
```

## 🎯 Cas d'usage

### Scénario 1 : Assistant public
- Utilisateur : Grand public
- URL : `/mcp/faq`
- Peut : Consulter les FAQs
- Ne peut pas : Créer des FAQs

### Scénario 2 : Assistant admin
- Utilisateur : Agent support
- URL : `/mcp/faq/admin`
- Peut : Consulter ET créer des FAQs
- Auth : OAuth automatique via Claude Desktop

### Scénario 3 : Integration n8n (à venir)
- Système : Automatisation n8n
- URL : `/mcp/faq/admin`
- Auth : Token OAuth stocké dans n8n
- Peut : Créer des FAQs automatiquement depuis emails/tickets

## 🐛 Dépannage

### Le tool create_faq n'apparaît pas dans le mode admin

**Vérifiez :**
1. Le middleware `auth:api` est bien appliqué
2. Le token OAuth est valide
3. `Auth::check()` retourne `true` dans `shouldRegister()`

```bash
# Tester si l'auth fonctionne
curl http://localhost:8000/api/user \
  -H "Authorization: Bearer VOTRE_TOKEN"
```

### La fenêtre OAuth ne s'ouvre pas

**Vérifiez :**
1. L'URL du serveur est accessible
2. Les routes OAuth sont bien enregistrées : `php artisan route:list | grep oauth`
3. Le client OAuth existe dans la base de données

## 📚 Ressources

- [Laravel Passport Documentation](https://laravel.com/docs/12.x/passport)
- [Laravel MCP Authentication](https://laravel.com/docs/12.x/mcp#authentication)
- [OAuth 2.1 Specification](https://oauth.net/2.1/)

## ✨ Prochaines étapes

- [ ] Créer des scopes personnalisés pour plus de granularité
- [ ] Ajouter des tools pour Update/Delete de FAQs (aussi protégés par auth)
- [ ] Configurer l'expiration des tokens
- [ ] Mettre en place le refresh token automatique
- [ ] Intégrer avec n8n pour automatisation
