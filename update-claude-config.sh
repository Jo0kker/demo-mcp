#!/bin/bash

# Script pour mettre à jour la configuration Claude Desktop avec les credentials OAuth
# Usage: ./update-claude-config.sh

set -e

echo "🔧 Mise à jour de la configuration Claude Desktop"
echo "================================================"
echo ""

# Déterminer le chemin du projet
PROJECT_PATH=$(cd "$(dirname "$0")" && pwd)

# Déterminer le système d'exploitation
if [[ "$OSTYPE" == "darwin"* ]]; then
    CONFIG_FILE="$HOME/Library/Application Support/Claude/claude_desktop_config.json"
    OS="macOS"
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    CONFIG_FILE="$HOME/.config/Claude/claude_desktop_config.json"
    OS="Linux"
elif [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    CONFIG_FILE="$APPDATA/Claude/claude_desktop_config.json"
    OS="Windows"
else
    echo "❌ Système d'exploitation non supporté: $OSTYPE"
    exit 1
fi

echo "💻 Système détecté: $OS"
echo "📂 Fichier de configuration: $CONFIG_FILE"
echo ""

# Lire les credentials depuis le .env
if [ ! -f "$PROJECT_PATH/.env" ]; then
    echo "❌ Fichier .env non trouvé !"
    echo "   Exécutez d'abord: php artisan mcp:setup-oauth"
    exit 1
fi

CLIENT_ID=$(grep MCP_OAUTH_CLIENT_ID "$PROJECT_PATH/.env" | cut -d '=' -f2)
CLIENT_SECRET=$(grep MCP_OAUTH_CLIENT_SECRET "$PROJECT_PATH/.env" | cut -d '=' -f2)

if [ -z "$CLIENT_ID" ]; then
    echo "❌ CLIENT_ID non trouvé dans le .env !"
    echo "   Exécutez d'abord: php artisan mcp:setup-oauth"
    exit 1
fi

if [ -z "$CLIENT_SECRET" ]; then
    echo "❌ CLIENT_SECRET non trouvé dans le .env !"
    echo "   Exécutez d'abord: php artisan mcp:setup-oauth"
    exit 1
fi

echo "✅ Client ID trouvé: $CLIENT_ID"
echo "✅ Client Secret trouvé (plaintext)"
echo ""

echo ""
echo "🔍 Vérification du serveur Laravel..."

# Vérifier si le serveur tourne déjà
if curl -s http://localhost:8000 > /dev/null 2>&1; then
    echo "✅ Serveur Laravel détecté sur http://localhost:8000"
    APP_URL="http://localhost:8000"
else
    echo "⚠️  Serveur Laravel non détecté sur le port 8000"
    echo "   Voulez-vous démarrer le serveur maintenant ? (o/n)"
    read -p "> " START_SERVER

    if [ "$START_SERVER" = "o" ] || [ "$START_SERVER" = "O" ]; then
        echo "🚀 Démarrage du serveur Laravel..."
        cd "$PROJECT_PATH"
        php artisan serve > /dev/null 2>&1 &
        SERVER_PID=$!
        echo "   Serveur démarré (PID: $SERVER_PID)"
        sleep 2
        APP_URL="http://localhost:8000"
    else
        echo "   Entrez l'URL de votre serveur (ex: http://localhost:8000):"
        read -p "> " APP_URL
    fi
fi

echo ""
echo "📋 Quel serveur voulez-vous configurer ?"
echo "  1) Public (lecture seule - sans OAuth)"
echo "  2) Admin (avec OAuth - création de FAQs)"
echo "  3) Les deux"
read -p "Choix (1/2/3): " CHOICE

# Sauvegarder l'ancienne config
if [ -f "$CONFIG_FILE" ]; then
    BACKUP_FILE="$CONFIG_FILE.backup.$(date +%Y%m%d_%H%M%S)"
    echo ""
    echo "💾 Sauvegarde de la configuration existante..."
    cp "$CONFIG_FILE" "$BACKUP_FILE"
    echo "   Backup: $BACKUP_FILE"
fi

# Créer le dossier si nécessaire
mkdir -p "$(dirname "$CONFIG_FILE")"

# Générer la configuration selon le choix
case $CHOICE in
    1)
        # Public uniquement
        cat > "$CONFIG_FILE" << EOF
{
  "mcpServers": {
    "demo-faq-public": {
      "command": "php",
      "args": [
        "$PROJECT_PATH/artisan",
        "mcp:start",
        "faq"
      ],
      "env": {
        "APP_ENV": "local"
      }
    }
  }
}
EOF
        echo ""
        echo "✅ Configuration PUBLIC créée !"
        echo "   Serveur: demo-faq-public"
        echo "   Tools: search_faqs, get_faq_categories"
        ;;

    2)
        # Admin uniquement
        cat > "$CONFIG_FILE" << EOF
{
  "mcpServers": {
    "demo-faq-admin": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "$APP_URL/mcp/faq"
      ],
      "oauth": {
        "authorizationUrl": "$APP_URL/oauth/authorize",
        "tokenUrl": "$APP_URL/oauth/token",
        "clientId": "$CLIENT_ID",
        "clientSecret": "$CLIENT_SECRET",
        "scopes": ["*"]
      }
    }
  }
}
EOF
        echo ""
        echo "✅ Configuration ADMIN créée !"
        echo "   Serveur: demo-faq-admin"
        echo "   Tools: search_faqs, get_faq_categories, create_faq"
        echo "   Auth: OAuth 2.1"
        ;;

    3)
        # Les deux
        cat > "$CONFIG_FILE" << EOF
{
  "mcpServers": {
    "demo-faq-public": {
      "command": "php",
      "args": [
        "$PROJECT_PATH/artisan",
        "mcp:start",
        "faq"
      ],
      "env": {
        "APP_ENV": "local"
      }
    },
    "demo-faq-admin": {
      "command": "npx",
      "args": [
        "@modelcontextprotocol/server-http",
        "$APP_URL/mcp/faq"
      ],
      "oauth": {
        "authorizationUrl": "$APP_URL/oauth/authorize",
        "tokenUrl": "$APP_URL/oauth/token",
        "clientId": "$CLIENT_ID",
        "clientSecret": "$CLIENT_SECRET",
        "scopes": ["*"]
      }
    }
  }
}
EOF
        echo ""
        echo "✅ Configuration COMPLETE créée !"
        echo "   Serveur PUBLIC: demo-faq-public (lecture)"
        echo "   Serveur ADMIN: demo-faq-admin (lecture + création)"
        ;;

    *)
        echo "❌ Choix invalide"
        exit 1
        ;;
esac

echo ""
echo "📄 Configuration sauvegardée dans:"
echo "   $CONFIG_FILE"
echo ""
echo "🔄 Prochaines étapes:"
echo "   1. Redémarrez Claude Desktop complètement"
echo "   2. Le(s) serveur(s) MCP seront chargés automatiquement"

if [ "$CHOICE" = "2" ] || [ "$CHOICE" = "3" ]; then
    echo "   3. Pour le serveur admin, une fenêtre de connexion OAuth s'ouvrira"
    echo "      Connectez-vous avec: test@example.com / password"
fi

echo ""
echo "✨ Configuration terminée !"
