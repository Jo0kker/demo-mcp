<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqListResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Liste complète de toutes les FAQs publiées dans la base de connaissances.
        Cette ressource fournit un aperçu de toutes les questions et réponses disponibles.
    MARKDOWN;

    /**
     * The resource's URI.
     */
    protected string $uri = 'faqs://all';

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $faqs = Faq::published()
            ->orderBy('category')
            ->orderBy('question')
            ->get()
            ->groupBy('category');

        $content = "# Base de connaissances FAQ\n\n";
        $content .= "Total de FAQs: " . Faq::published()->count() . "\n\n";

        foreach ($faqs as $category => $categoryFaqs) {
            $categoryName = $category ?: 'Sans catégorie';
            $content .= "## {$categoryName}\n\n";

            foreach ($categoryFaqs as $faq) {
                $content .= "### Q: {$faq->question}\n\n";
                $content .= "**R:** {$faq->answer}\n\n";
                $content .= "_Vues: {$faq->view_count}_\n\n";
                $content .= "---\n\n";
            }
        }

        return Response::text($content);
    }
}
