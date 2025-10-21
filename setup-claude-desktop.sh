#!/bin/bash

# Script de configuration automatique pour Claude Desktop
# Usage: ./setup-claude-desktop.sh

set -e

echo "🚀 Configuration de Claude Desktop pour Demo MCP"
echo "================================================"
echo ""

# Déterminer le chemin absolu du projet
PROJECT_PATH=$(cd "$(dirname "$0")" && pwd)
echo "📁 Chemin du projet: $PROJECT_PATH"
echo ""

# Déterminer le système d'exploitation
if [[ "$OSTYPE" == "darwin"* ]]; then
    CONFIG_DIR="$HOME/Library/Application Support/Claude"
    OS="macOS"
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    CONFIG_DIR="$HOME/.config/Claude"
    OS="Linux"
elif [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    CONFIG_DIR="$APPDATA/Claude"
    OS="Windows"
else
    echo "❌ Système d'exploitation non supporté: $OSTYPE"
    exit 1
fi

echo "💻 Système détecté: $OS"
echo "📂 Dossier de configuration: $CONFIG_DIR"
echo ""

# Vérifier que PHP est disponible
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé ou n'est pas dans le PATH"
    echo "   Installez PHP et réessayez"
    exit 1
fi

PHP_VERSION=$(php --version | head -n 1)
echo "✅ PHP détecté: $PHP_VERSION"
echo ""

# Vérifier que le projet Laravel fonctionne
if [ ! -f "$PROJECT_PATH/artisan" ]; then
    echo "❌ Fichier artisan non trouvé dans $PROJECT_PATH"
    exit 1
fi

echo "✅ Projet Laravel trouvé"
echo ""

# Créer le dossier de configuration s'il n'existe pas
mkdir -p "$CONFIG_DIR"

CONFIG_FILE="$CONFIG_DIR/claude_desktop_config.json"

# Sauvegarder l'ancienne configuration si elle existe
if [ -f "$CONFIG_FILE" ]; then
    BACKUP_FILE="$CONFIG_FILE.backup.$(date +%Y%m%d_%H%M%S)"
    echo "💾 Sauvegarde de la configuration existante: $BACKUP_FILE"
    cp "$CONFIG_FILE" "$BACKUP_FILE"
    echo ""

    # Vérifier si le fichier contient déjà d'autres serveurs
    if grep -q "mcpServers" "$CONFIG_FILE"; then
        echo "⚠️  Configuration existante détectée!"
        echo "   Veuillez ajouter manuellement la configuration suivante à votre fichier:"
        echo ""
        echo "   \"demo-faq\": {"
        echo "     \"command\": \"php\","
        echo "     \"args\": ["
        echo "       \"$PROJECT_PATH/artisan\","
        echo "       \"mcp:start\","
        echo "       \"faq\""
        echo "     ],"
        echo "     \"env\": {"
        echo "       \"APP_ENV\": \"local\""
        echo "     }"
        echo "   }"
        echo ""
        echo "📝 Fichier de configuration: $CONFIG_FILE"
        exit 0
    fi
fi

# Créer la nouvelle configuration
echo "📝 Création de la configuration..."
cat > "$CONFIG_FILE" << EOF
{
  "mcpServers": {
    "demo-faq": {
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

echo "✅ Configuration créée avec succès!"
echo ""
echo "📄 Fichier de configuration: $CONFIG_FILE"
echo ""
echo "🔄 Prochaines étapes:"
echo "   1. Redémarrez Claude Desktop"
echo "   2. Le serveur MCP 'demo-faq' devrait être disponible"
echo "   3. Testez avec: 'Liste les catégories de FAQ disponibles'"
echo ""
echo "✨ Configuration terminée!"
