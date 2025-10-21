<?php

namespace App\Mcp\Tools;

use App\Models\Faq;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class GetFaqCategoriesTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Récupère la liste de toutes les catégories de FAQ disponibles.
        Utile pour connaître les catégories existantes avant de faire une recherche filtrée.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $categories = Faq::published()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return Response::json([
            'categories' => $categories,
            'total' => $categories->count(),
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            // Pas de paramètres requis pour cet outil
        ];
    }
}
