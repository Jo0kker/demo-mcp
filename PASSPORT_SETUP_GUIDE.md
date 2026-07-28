# 🔐 Guide de Configuration Passport OAuth

## 🚀 Configuration rapide

### 1. Créer le client OAuth

```bash
php artisan mcp:setup-oauth
```

Cette commande va :
- ✅ Créer un client OAuth Password Grant
- ✅ Afficher les credentials (Client ID + Secret plaintext)
- ✅ Mettre à jour le `.env` automatiquement
- ✅ Afficher la configuration prête pour Claude Desktop

### 2. Copier les credentials

⚠️ **IMPORTANT** : Le secret affiché par Passport est le **plaintext**, notez-le !

Exemple de sortie :
```
Client ID ............................. VOTRE_CLIENT_ID
Client Secret ......................... VOTRE_CLIENT_SECRET
```

**Le secret à utiliser est** : `pQ4C4HiGvtVWESR9MZfRz7RLJHdTmaOYJ5QQvi61`

### 3. Configuration Claude Desktop

La commande affiche automatiquement la config JSON complète :

```json
{
  "mcpServers": {
    "demo-faq-admin": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "http://localhost:8000/mcp/faq"
      ],
      "oauth": {
        "authorizationUrl": "http://localhost:8000/oauth/authorize",
        "tokenUrl": "http://localhost:8000/oauth/token",
        "clientId": "019a06c1-8fa6-7106-a400-d01da14776d6",
        "clientSecret": "VOTRE_CLIENT_SECRET",
        "scopes": ["*"]
      }
    }
  }
}
```

### 4. Fichier de configuration

**macOS** : `~/Library/Application Support/Claude/claude_desktop_config.json`
**Windows** : `%APPDATA%\Claude\claude_desktop_config.json`
**Linux** : `~/.config/Claude/claude_desktop_config.json`

### 5. Red

émarrer Claude Desktop

Fermez complètement et relancez Claude Desktop pour charger la config.

## 🔄 Régénérer les credentials

Si vous avez perdu le secret ou voulez en créer un nouveau :

```bash
php artisan mcp:setup-oauth --force
```

## 📊 Variables d'environnement

Le fichier `.env` contiendra :

```env
# MCP OAuth Configuration
MCP_OAUTH_CLIENT_ID=019a06c1-8fa6-7106-a400-d01da14776d6
MCP_OAUTH_CLIENT_SECRET=le_secret_hashé_dans_la_bdd
```

⚠️ Le secret dans le `.env` est hashé. Pour Claude Desktop, utilisez le **plaintext** affiché lors de la création.

## 🎯 En production

### 1. Sur votre serveur

```bash
# Sur le serveur de production
php artisan mcp:setup-oauth
```

### 2. Notez les credentials

Copiez le Client ID et le Secret plaintext affichés.

### 3. Variables d'environnement production

Ajoutez dans votre `.env` de production :

```env
APP_URL=https://votre-domaine.com
MCP_OAUTH_CLIENT_ID=le_client_id_généré
MCP_OAUTH_CLIENT_SECRET=le_secret_hashé
```

### 4. Configuration Claude Desktop (production)

```json
{
  "mcpServers": {
    "demo-faq-production": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "https://votre-domaine.com/mcp/faq"
      ],
      "oauth": {
        "authorizationUrl": "https://votre-domaine.com/oauth/authorize",
        "tokenUrl": "https://votre-domaine.com/oauth/token",
        "clientId": "le_client_id",
        "clientSecret": "VOTRE_CLIENT_SECRET",
        "scopes": ["*"]
      }
    }
  }
}
```

## ✅ Vérifier la configuration

### Tester l'OAuth manuellement

```bash
# 1. Démarrer le serveur
php artisan serve

# 2. Obtenir un token
curl -X POST http://localhost:8000/oauth/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "password",
    "client_id": "VOTRE_CLIENT_ID",
    "client_secret": "VOTRE_SECRET_PLAINTEXT",
    "username": "test@example.com",
    "password": "password",
    "scope": "*"
  }'
```

Vous devriez recevoir :
```json
{
  "token_type": "Bearer",
  "expires_in": 31536000,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refresh_token": "def50200..."
}
```

### Tester le serveur MCP protégé

```bash
curl http://localhost:8000/mcp/faq \
  -H "Authorization: Bearer VOTRE_ACCESS_TOKEN" \
  -H "Content-Type: application/json"
```

## 🔍 Dépannage

### Erreur "Invalid client credentials"

- Vérifiez que vous utilisez le **secret plaintext**, pas le hash
- Vérifiez le Client ID

### Le tool create_faq n'apparaît pas

- Vérifiez que vous utilisez `/mcp/faq` (pas `/mcp/faq`)
- Vérifiez que l'OAuth est configuré dans Claude Desktop
- Vérifiez que vous êtes bien authentifié

### Erreur "Unauthenticated"

- Le token OAuth a peut-être expiré
- Reconnectez-vous via Claude Desktop

## 📚 Commandes utiles

```bash
# Lister les clients OAuth
php artisan tinker --execute="Laravel\Passport\Client::all();"

# Supprimer un client
php artisan tinker --execute="Laravel\Passport\Client::find('client-id')->delete();"

# Vider le cache de config
php artisan config:clear
```

## 🎓 Résumé du flux OAuth

1. **Claude Desktop** demande accès au serveur MCP admin
2. **Fenêtre navigateur** s'ouvre automatiquement
3. **Vous vous connectez** avec test@example.com / password
4. **Vous autorisez** l'application
5. **Claude reçoit** un access token OAuth
6. **Le tool `create_faq`** devient disponible (shouldRegister() = true)
7. **Vous pouvez** créer des FAQs via Claude !
