<?php

namespace App\Mcp\Prompts;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class SuggestFaqPrompt extends Prompt
{
    /**
     * The prompt's description.
     */
    protected string $description = <<<'MARKDOWN'
        Suggère de nouvelles FAQs ou des améliorations basées sur un sujet ou une question courante.
        Aide à enrichir la base de connaissances.
    MARKDOWN;

    /**
     * Handle the prompt request.
     */
    public function handle(Request $request): Response
    {
        $topic = $request->string('topic');
        $createIfApproved = $request->boolean('create_if_approved', false);

        $createInstruction = $createIfApproved
            ? "Si l'utilisateur approuve une suggestion, utilise l'outil `create_faq` pour l'ajouter à la base de connaissances."
            : "Présente les suggestions sans les créer automatiquement.";

        $messages = [
            [
                'role' => 'user',
                'content' => [
                    'type' => 'text',
                    'text' => <<<TEXT
                    Analyse la base de connaissances et suggère de nouvelles FAQs sur le sujet : "{$topic}"

                    Processus :
                    1. Utilise `search_faqs` pour voir si des FAQs existent déjà sur ce sujet
                    2. Utilise `get_faq_categories` pour identifier la catégorie appropriée
                    3. Analyse les lacunes ou points non couverts
                    4. Propose 3-5 nouvelles FAQs pertinentes avec :
                       - Une question claire et précise
                       - Une réponse complète et utile
                       - La catégorie recommandée
                       - Une justification de pourquoi cette FAQ serait utile

                    {$createInstruction}

                    Format de suggestion :
                    ## FAQ Suggérée #1
                    **Question :** [Question claire]
                    **Réponse :** [Réponse détaillée]
                    **Catégorie :** [Catégorie recommandée]
                    **Justification :** [Pourquoi cette FAQ est importante]

                    ---

                    Fournis des suggestions de qualité qui aideront vraiment les utilisateurs.
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
            'topic' => $schema->string()
                ->description('Le sujet ou thème pour lequel suggérer de nouvelles FAQs')
                ->required(),
            'create_if_approved' => $schema->boolean()
                ->description('Si true, permet de créer automatiquement les FAQs après approbation')
                ->default(false),
        ];
    }
}
