<?php

use App\Mcp\Servers\FaqServer;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Facades\Mcp;

// Enregistrer les routes OAuth 2.1 pour l'authentification MCP
// Ces routes permettent le flux d'authentification OAuth pour les clients MCP
Mcp::oauthRoutes();

// Alias oauth2 -> oauth pour compatibilité avec GPT et autres clients
Route::get('/oauth2/authorize', function () {
    return redirect('/oauth/authorize?' . http_build_query(request()->all()));
})->name('oauth2.authorize');

Route::post('/oauth2/token', function () {
    return redirect('/oauth/token');
})->name('oauth2.token');

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
