<?php

namespace App\Mcp\Prompts;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class HelpUserPrompt extends Prompt
{
    /**
     * The prompt's description.
     */
    protected string $description = <<<'MARKDOWN'
        Guide l'IA pour aider un utilisateur avec sa question en recherchant dans la base de connaissances FAQ.
        Utilise les outils de recherche disponibles pour trouver la meilleure réponse.
    MARKDOWN;

    /**
     * Handle the prompt request.
     */
    public function handle(Request $request): Response
    {
        $userQuestion = $request->string('question');

        $messages = [
            [
                'role' => 'user',
                'content' => [
                    'type' => 'text',
                    'text' => <<<TEXT
                    Un utilisateur a posé la question suivante :
                    "{$userQuestion}"

                    Ta mission :
                    1. Utilise l'outil `search_faqs` pour rechercher des FAQs pertinentes en utilisant des mots-clés de la question
                    2. Si nécessaire, utilise `get_faq_categories` pour explorer les catégories disponibles
                    3. Analyse les résultats et fournis une réponse claire et structurée
                    4. Si tu trouves plusieurs FAQs pertinentes, présente-les de manière organisée
                    5. Si aucune FAQ ne correspond, indique-le clairement et suggère de reformuler ou de contacter le support

                    Format de réponse :
                    - Commence par une réponse directe
                    - Liste les FAQs pertinentes trouvées
                    - Fournis les informations détaillées
                    - Termine par des suggestions si nécessaire
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
            'question' => $schema->string()
                ->description('La question posée par l\'utilisateur')
                ->required(),
        ];
    }
}
