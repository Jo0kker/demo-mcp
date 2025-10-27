<?php

namespace App\Mcp\Tools;

use App\Models\Faq;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class SearchFaqsTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Recherche dans la base de connaissances FAQ.
        Utilisez cet outil pour trouver des réponses aux questions des utilisateurs.
        Vous pouvez rechercher par mots-clés ou filtrer par catégorie.
    MARKDOWN;

    /**
     * Override to add required field for n8n compatibility.
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        // Ensure required field exists for n8n compatibility
        if (isset($array['inputSchema']) && isset($array['inputSchema']['properties'])) {
            $array['inputSchema']['required'] = [];
        }

        return $array;
    }

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $query = Faq::query()->published();

        // Recherche par texte
        if ($search = $request->string('query')) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Filtre par catégorie
        if ($category = $request->string('category')) {
            $query->byCategory($category);
        }

        $faqs = $query->limit($request->integer('limit', 10))->get();

        if ($faqs->isEmpty()) {
            return Response::text('Aucune FAQ trouvée pour cette recherche.');
        }

        $results = $faqs->map(function ($faq) {
            return [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
                'category' => $faq->category,
                'view_count' => $faq->view_count,
            ];
        });

        return Response::json($results);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()
                ->description('Le texte à rechercher dans les questions et réponses (optionnel, laissez vide pour tout afficher)')
                ->default(''),
            'category' => $schema->string()
                ->description('Filtrer par catégorie (optionnel)')
                ->default(''),
            'limit' => $schema->number()
                ->description('Nombre maximum de résultats (défaut: 10)')
                ->default(10),
        ];
    }
}
