<?php

namespace App\Mcp\Prompts;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class CategorySummaryPrompt extends Prompt
{
    /**
     * The prompt's description.
     */
    protected string $description = <<<'MARKDOWN'
        Génère un résumé complet de toutes les FAQs d'une catégorie spécifique.
        Utile pour avoir une vue d'ensemble d'un sujet particulier.
    MARKDOWN;

    /**
     * Handle the prompt request.
     */
    public function handle(Request $request): Response
    {
        $category = $request->string('category');

        $messages = [
            [
                'role' => 'user',
                'content' => [
                    'type' => 'text',
                    'text' => <<<TEXT
                    Génère un résumé complet de la catégorie "{$category}" de notre base de connaissances.

                    Étapes à suivre :
                    1. Utilise l'outil `search_faqs` avec le filtre category="{$category}"
                    2. Analyse toutes les FAQs de cette catégorie
                    3. Crée un résumé structuré qui inclut :
                       - Un aperçu général de ce que couvre cette catégorie
                       - Les questions les plus importantes
                       - Les points clés à retenir
                       - Le nombre total de FAQs dans cette catégorie

                    Format attendu :
                    # Résumé de la catégorie {$category}

                    ## Vue d'ensemble
                    [Description générale]

                    ## Questions principales
                    - Question 1 : [Résumé de la réponse]
                    - Question 2 : [Résumé de la réponse]
                    ...

                    ## Points clés
                    - Point 1
                    - Point 2
                    ...

                    ## Statistiques
                    Total : X FAQs dans cette catégorie
                    TEXT,
                ],
            ],
        ];

        return Response::messages($messages);
    }

    /**
     * Get the prompt's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category' => $schema->string()
                ->description('La catégorie de FAQs à résumer (ex: Technique, Facturation, Compte)')
                ->required(),
        ];
    }
}
