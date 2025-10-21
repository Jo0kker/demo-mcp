<?php

namespace App\Mcp\Servers;

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
        - **faqs://all** : Accès à la liste complète de toutes les FAQs

        ## Comment utiliser ce serveur :

        1. Pour aider un utilisateur, commencez par rechercher dans les FAQs avec l'outil `search_faqs`
        2. Vous pouvez filtrer par catégorie si nécessaire
        3. La ressource `faqs://all` vous donne une vue d'ensemble de toute la base de connaissances
        4. Fournissez des réponses claires basées sur les informations trouvées

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
        FaqListResource::class,
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
