<?php

namespace App\Mcp\Servers;

use App\Mcp\Prompts\AnalyzeKnowledgeBasePrompt;
use App\Mcp\Prompts\CategorySummaryPrompt;
use App\Mcp\Prompts\HelpUserPrompt;
use App\Mcp\Prompts\SuggestFaqPrompt;
use App\Mcp\Resources\FaqByIdResource;
use App\Mcp\Resources\FaqCategoryResource;
use App\Mcp\Resources\FaqCompactResource;
use App\Mcp\Resources\FaqCsvResource;
use App\Mcp\Resources\FaqHtmlResource;
use App\Mcp\Resources\FaqJsonResource;
use App\Mcp\Resources\FaqListResource;
use App\Mcp\Tools\CreateFaqTool;
use App\Mcp\Tools\GetFaqCategoriesTool;
use App\Mcp\Tools\SearchFaqsTool;
use Laravel\Mcp\Server;

class FaqServer extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'FAQ Support Server';

    /**
     * The MCP server's version.
     */
    protected string $version = '1.1.0';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        Ce serveur MCP donne accès à une base de connaissances FAQ (Foire Aux Questions).

        ## Capacités disponibles :

        ### Outils (Tools)
        - **search_faqs** : Rechercher des FAQs par mots-clés ou catégorie
        - **get_faq_categories** : Obtenir la liste des catégories disponibles
        - **create_faq** : Créer une nouvelle FAQ dans la base de connaissances

        ### Ressources (Resources)
        **Ressources statiques :**
        - **faqs://all** : Liste complète en Markdown (format détaillé)
        - **faqs://json** : Export JSON structuré (pour API/intégrations)
        - **faqs://html** : Page HTML prête à afficher (avec styles CSS)
        - **faqs://csv** : Export CSV (Excel/Google Sheets compatible)
        - **faqs://compact** : Format texte condensé (optimisé pour LLM)

        **Ressources dynamiques (templates) :**
        - **faqs://category/{category}** : FAQs d'une catégorie spécifique (ex: faqs://category/Technique)
        - **faqs://id/{id}** : Une FAQ spécifique par son ID (ex: faqs://id/42)

        ### Prompts (Modèles pré-définis)
        - **help_user** : Guide pour aider un utilisateur avec sa question
        - **category_summary** : Génère un résumé complet d'une catégorie
        - **suggest_faq** : Suggère de nouvelles FAQs sur un sujet
        - **analyze_knowledge_base** : Analyse complète de la base de connaissances

        ## Comment utiliser ce serveur :

        1. **Pour aider un utilisateur** : Utilisez le prompt `help_user` ou l'outil `search_faqs`
        2. **Pour explorer une catégorie** : Utilisez le prompt `category_summary`
        3. **Pour enrichir la base** : Utilisez le prompt `suggest_faq`
        4. **Pour un audit complet** : Utilisez le prompt `analyze_knowledge_base`

        ## Catégories typiques :
        - Technique
        - Facturation
        - Compte
        - Général
        - Sécurité
    MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        SearchFaqsTool::class,
        GetFaqCategoriesTool::class,
        CreateFaqTool::class,
    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Resource>>
     */
    protected array $resources = [
        // Resources statiques
        FaqListResource::class,      // faqs://all - Markdown complet
        FaqJsonResource::class,      // faqs://json - JSON structuré
        FaqHtmlResource::class,      // faqs://html - HTML formaté
        FaqCsvResource::class,       // faqs://csv - Export CSV
        FaqCompactResource::class,   // faqs://compact - Format condensé

        // Resource templates (avec paramètres dynamiques)
        FaqCategoryResource::class,  // faqs://category/{category} - FAQs par catégorie
        FaqByIdResource::class,      // faqs://id/{id} - FAQ spécifique
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Prompt>>
     */
    protected array $prompts = [
        HelpUserPrompt::class,
        CategorySummaryPrompt::class,
        SuggestFaqPrompt::class,
        AnalyzeKnowledgeBasePrompt::class,
    ];
}
