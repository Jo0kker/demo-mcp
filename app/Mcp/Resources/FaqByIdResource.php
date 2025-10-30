<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqByIdResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Accède à une FAQ spécifique par son ID.
        Remplacez {id} par l'ID numérique de la FAQ.
    MARKDOWN;

    /**
     * The resource's URI template.
     */
    protected string $uri = 'faqs://id/{id}';

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $id = $request->integer('id');

        $faq = Faq::published()->find($id);

        if (! $faq) {
            return Response::text("# Erreur\n\nAucune FAQ trouvée avec l'ID #{$id}");
        }

        $category = $faq->category ?: 'Sans catégorie';

        $content = <<<MARKDOWN
        # {$faq->question}

        **Catégorie :** {$category}
        **Consultations :** {$faq->view_count}
        **Créée le :** {$faq->created_at->format('d/m/Y à H:i')}

        ---

        ## Réponse

        {$faq->answer}

        ---

        _FAQ #{$faq->id}_
        MARKDOWN;

        return Response::text($content);
    }
}
