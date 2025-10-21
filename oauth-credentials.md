# 🔐 Credentials OAuth - Demo MCP

## Client OAuth Password Grant

**Client Name:** Support-bot

**Client ID:**
```
019a06bb-b384-704e-93cb-5a23bb1d87d1
```

**Client Secret:**
```
RxPFwA3n7uC5YbKpoCBSiG0faTkyFvNOuZKqqKg9
```

⚠️ **Important** : Ne partagez jamais ces credentials publiquement !

## Configuration Claude Desktop (avec OAuth)

```json
{
  "mcpServers": {
    "demo-faq-admin": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "http://localhost:8000/mcp/faq/admin"
      ],
      "oauth": {
        "authorizationUrl": "http://localhost:8000/oauth/authorize",
        "tokenUrl": "http://localhost:8000/oauth/token",
        "clientId": "019a06bb-b384-704e-93cb-5a23bb1d87d1",
        "clientSecret": "RxPFwA3n7uC5YbKpoCBSiG0faTkyFvNOuZKqqKg9",
        "scopes": ["*"]
      }
    }
  }
}
```

## Configuration Claude Desktop (sans OAuth - public)

```json
{
  "mcpServers": {
    "demo-faq-public": {
      "command": "php",
      "args": [
        "/Users/benjamin-roma-sacconney/projects/demo-mcp/artisan",
        "mcp:start",
        "faq"
      ]
    }
  }
}
```

## Tester manuellement l'OAuth

### 1. Démarrer le serveur Laravel
```bash
php artisan serve
```

### 2. Obtenir un token via mot de passe
```bash
curl -X POST http://localhost:8000/oauth/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "password",
    "client_id": "019a06bb-b384-704e-93cb-5a23bb1d87d1",
    "client_secret": "RxPFwA3n7uC5YbKpoCBSiG0faTkyFvNOuZKqqKg9",
    "username": "test@example.com",
    "password": "password",
    "scope": "*"
  }'
```

### 3. Utiliser le token pour accéder au serveur MCP
```bash
curl http://localhost:8000/mcp/faq/admin \
  -H "Authorization: Bearer VOTRE_ACCESS_TOKEN" \
  -H "Content-Type: application/json"
```

## Utilisateur de test

- **Email:** test@example.com
- **Password:** password

(Créé par le DatabaseSeeder)

## Créé le
2025-10-21
