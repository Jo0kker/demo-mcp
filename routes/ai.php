<?php

use App\Mcp\Servers\FaqServer;
use Laravel\Mcp\Facades\Mcp;

// Enregistrer les routes OAuth 2.1 pour l'authentification MCP
// Ces routes permettent le flux d'authentification OAuth pour les clients MCP
Mcp::oauthRoutes();

// Serveur MCP local pour développement (accessible via artisan)
// Usage: php artisan mcp:start faq
Mcp::local('faq', FaqServer::class);

// Serveur MCP web PUBLIC (sans authentification)
// - Accès en lecture seule
// - Tools disponibles: search_faqs, get_faq_categories
// - Tool create_faq masqué (shouldRegister() retourne false)
Mcp::web('/mcp/faq', FaqServer::class);

// Serveur MCP web PROTÉGÉ (avec OAuth 2.1)
// - Nécessite authentification OAuth
// - Tous les tools disponibles (y compris create_faq)
// - Configuration: php artisan mcp:setup-oauth
Mcp::web('/mcp/faq/admin', FaqServer::class)
    ->middleware(['auth:api']);
