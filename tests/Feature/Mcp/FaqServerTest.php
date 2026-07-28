<?php

use App\Mcp\Resources\FaqCategoryResource;
use App\Mcp\Servers\FaqServer;
use App\Mcp\Tools\GetFaqCategoriesTool;
use App\Mcp\Tools\SearchFaqsTool;
use App\Models\Faq;

test('searches published FAQs by keyword', function () {
    Faq::factory()->create([
        'question' => 'Comment réinitialiser mon mot de passe ?',
        'answer' => 'Utilisez le lien reçu par email.',
        'category' => 'Compte',
        'is_published' => true,
    ]);

    Faq::factory()->create([
        'question' => 'FAQ privée',
        'answer' => 'mot de passe',
        'category' => 'Compte',
        'is_published' => false,
    ]);

    FaqServer::tool(SearchFaqsTool::class, ['query' => 'mot de passe'])
        ->assertOk()
        ->assertSee('mot de passe')
        ->assertDontSee('FAQ privée');
});

test('lists categories and reads a category resource', function () {
    Faq::factory()->create([
        'question' => 'Comment télécharger une facture ?',
        'answer' => 'Depuis votre espace de facturation.',
        'category' => 'Facturation',
        'is_published' => true,
    ]);

    FaqServer::tool(GetFaqCategoriesTool::class)
        ->assertOk()
        ->assertSee('Facturation');

    FaqServer::resource(FaqCategoryResource::class, [
        'category' => 'Facturation',
    ])
        ->assertOk()
        ->assertSee('Comment télécharger une facture ?');
});
