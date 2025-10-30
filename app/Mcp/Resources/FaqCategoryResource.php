<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqCategoryResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Accède aux FAQs d'une catégorie spécifique.
        Remplacez {category} par le nom de la catégorie (ex: Technique, Facturation, Compte).
    MARKDOWN;

    /**
     * The resource's URI template.
     */
    protected string $uri = 'faqs://category/{category}';

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $category = $request->string('category');

        $faqs = Faq::published()
            ->byCategory($category)
            ->orderBy('view_count', 'desc')
            ->get();

        if ($faqs->isEmpty()) {
            return Response::text("# Catégorie: {$category}\n\nAucune FAQ trouvée dans cette catégorie.");
        }

        $content = "# Catégorie: {$category}\n\n";
        $content .= "**Nombre de FAQs :** {$faqs->count()}\n\n";
        $content .= "---\n\n";

        foreach ($faqs as $faq) {
            $content .= "## Q: {$faq->question}\n\n";
            $content .= "**R:** {$faq->answer}\n\n";
            $content .= "_👁️ {$faq->view_count} consultation(s)_\n\n";
            $content .= "---\n\n";
        }

        return Response::text($content);
    }
}
