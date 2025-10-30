<?php

use App\Mcp\Servers\FaqServer;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Facades\Mcp;

Mcp::oauthRoutes();

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

Mcp::local('faq', FaqServer::class);

Mcp::web('/mcp/faq', FaqServer::class);
