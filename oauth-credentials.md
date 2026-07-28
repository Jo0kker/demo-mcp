# Configuration OAuth - Demo MCP

Ce document contient uniquement des exemples. Ne stockez jamais de secret OAuth
ou de mot de passe réel dans le dépôt.

## Configuration du client

Créez le client OAuth avec la commande dédiée :

```bash
php artisan mcp:setup-oauth
```

Conservez l'identifiant et le secret générés dans votre gestionnaire de secrets.
Remplacez les placeholders ci-dessous uniquement dans votre configuration locale,
jamais dans ce fichier suivi par Git.

## Configuration Claude Desktop avec OAuth

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
        "clientId": "VOTRE_CLIENT_ID",
        "clientSecret": "VOTRE_CLIENT_SECRET",
        "scopes": ["mcp:use"]
      }
    }
  }
}
```

## Configuration Claude Desktop sans OAuth

Le serveur local est démarré directement par le client :

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

## Tester le serveur web

1. Démarrez Laravel :

```bash
php artisan serve
```

2. Utilisez le flux OAuth configuré par Laravel MCP, puis envoyez le jeton au
   serveur :

```bash
curl http://localhost:8000/mcp/faq \
  -H "Authorization: Bearer VOTRE_JETON_D_ACCES" \
  -H "Content-Type: application/json"
```

Révoquez immédiatement tout identifiant ou secret qui a déjà été ajouté à
l'historique Git.
