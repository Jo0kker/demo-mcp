<?php

namespace App\Mcp\Prompts;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class AnalyzeKnowledgeBasePrompt extends Prompt
{
    /**
     * The prompt's description.
     */
    protected string $description = <<<'MARKDOWN'
        Analyse complète de la base de connaissances FAQ.
        Fournit des statistiques, identifie les lacunes et suggère des améliorations.
    MARKDOWN;

    /**
     * Handle the prompt request.
     */
    public function handle(Request $request): Response
    {
        $messages = [
            [
                'role' => 'user',
                'content' => [
                    'type' => 'text',
                    'text' => <<<'TEXT'
                    Effectue une analyse complète de notre base de connaissances FAQ.

                    Tâches à accomplir :
                    1. Utilise `get_faq_categories` pour lister toutes les catégories
                    2. Pour chaque catégorie, utilise `search_faqs` pour obtenir les FAQs
                    3. Analyse la couverture et la qualité du contenu

                    Produis un rapport structuré incluant :

                    ## 📊 Statistiques Générales
                    - Nombre total de FAQs
                    - Nombre de catégories
                    - Répartition par catégorie

                    ## 📁 Analyse par Catégorie
                    Pour chaque catégorie :
                    - Nombre de FAQs
                    - Thèmes principaux couverts
                    - Évaluation de la couverture (bonne/moyenne/faible)

                    ## ⚠️ Lacunes Identifiées
                    - Catégories sous-représentées
                    - Sujets probablement manquants
                    - Questions courantes non couvertes

                    ## 💡 Recommandations
                    - Priorités pour l'enrichissement
                    - Catégories à développer
                    - Suggestions d'amélioration

                    ## 🎯 Actions Suggérées
                    Liste 5 actions concrètes pour améliorer la base de connaissances

                    Sois précis et actionnable dans tes recommandations.
                    TEXT,
                ],
            ],
        ];

        return Response::messages($messages);
    }

    /**
     * Get the prompt's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            // Pas de paramètres requis pour ce prompt
        ];
    }
}
