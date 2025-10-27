<?php

use App\Mcp\Servers\FaqServer;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Facades\Mcp;

// Enregistrer les routes OAuth 2.1 pour l'authentification MCP
// Ces routes permettent le flux d'authentification OAuth pour les clients MCP
Mcp::oauthRoutes();

// Alias oauth2 -> oauth pour compatibilité avec GPT et autres clients
// Forward au lieu de redirect pour éviter l'erreur "unsafe URL"
Route::get('/oauth2/authorize', function () {
    request()->merge(request()->query());
    return app()->handle(
        request()->create('/oauth/authorize', 'GET', request()->all())
    );
})->name('oauth2.authorize');

Route::post('/oauth2/token', function () {
    return app()->handle(
        request()->create('/oauth/token', 'POST', request()->all())
    );
})->name('oauth2.token');

// Serveur MCP local pour développement (accessible via artisan)
// Usage: php artisan mcp:start faq
Mcp::local('faq', FaqServer::class);

// Serveur MCP web PUBLIC (sans authentification)
// - Accès en lecture seule
// - Tools disponibles: search_faqs, get_faq_categories
// - Tool create_faq masqué (shouldRegister() retourne false)
Mcp::web('/mcp/faq', FaqServer::class);

// Serveur MCP web PROTÉGÉ (avec OAuth 2.1 ou Personal Access Token)
// - Nécessite authentification OAuth (Passport) ou Personal Access Token (Sanctum)
// - Tous les tools disponibles (y compris create_faq)
// - Configuration OAuth: php artisan mcp:setup-oauth
// - Token personnel: depuis l'interface web dans Settings > API Tokens
Mcp::web('/mcp/faq/admin', FaqServer::class)
    ->middleware(['auth:sanctum,api']);
