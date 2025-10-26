<?php

namespace App\Mcp\Tools;

use App\Models\Faq;
use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateFaqTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Crée une nouvelle FAQ dans la base de connaissances.
        Utilisez cet outil pour ajouter de nouvelles questions et réponses.
        La FAQ sera automatiquement publiée par défaut.

        ⚠️ Nécessite une authentification OAuth.
    MARKDOWN;

    /**
     * Determine if the tool should be registered.
     *
     * Le tool n'est disponible que si l'utilisateur est authentifié via OAuth.
     * Cela permet de masquer le tool pour les accès publics non authentifiés.
     *
     * TEMPORAIRE : Activé pour tous les contextes pendant les tests
     */
    public function shouldRegister(): bool
    {
        // Vérifier si un token Bearer est présent dans la requête
        $hasToken = request()->bearerToken() !== null;

        // Le tool est visible si :
        // - L'utilisateur est authentifié via session (Auth::check())
        // - OU un token Bearer OAuth est présent
        return Auth::check() || $hasToken;
    }

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return Response::error(
                'Validation failed: ' . $validator->errors()->first()
            );
        }

        // Création de la FAQ
        $faq = Faq::create([
            'question' => $request->string('question'),
            'answer' => $request->string('answer'),
            'category' => $request->string('category') ?: null,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return Response::json([
            'success' => true,
            'message' => 'FAQ créée avec succès !',
            'faq' => [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
                'category' => $faq->category,
                'is_published' => $faq->is_published,
                'created_at' => $faq->created_at,
            ],
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
            'question' => $schema->string()
                ->description('La question de la FAQ (obligatoire)')
                ->required(),
            'answer' => $schema->string()
                ->description('La réponse détaillée à la question (obligatoire)')
                ->required(),
            'category' => $schema->string()
                ->description('Catégorie de la FAQ (optionnel). Exemples: Technique, Facturation, Compte, Général, Sécurité'),
            'is_published' => $schema->boolean()
                ->description('Publier immédiatement la FAQ (défaut: true)')
                ->default(true),
        ];
    }
}
