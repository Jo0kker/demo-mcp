<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqCompactResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Vue compacte et optimisée des FAQs au format texte.
        Format condensé parfait pour les LLM avec contexte limité.
    MARKDOWN;

    /**
     * The resource's URI.
     */
    protected string $uri = 'faqs://compact';

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $faqs = Faq::published()
            ->orderBy('category')
            ->orderBy('view_count', 'desc')
            ->get()
            ->groupBy('category');

        $content = "=== BASE DE CONNAISSANCES FAQ ===\n";
        $content .= "Total: " . Faq::published()->count() . " FAQs\n\n";

        foreach ($faqs as $category => $categoryFaqs) {
            $categoryName = $category ?: 'GÉNÉRAL';
            $content .= "## {$categoryName} ({$categoryFaqs->count()})\n\n";

            foreach ($categoryFaqs as $faq) {
                $content .= "Q: {$faq->question}\n";
                $content .= "R: " . str_replace("\n", " ", $faq->answer) . "\n";
                $content .= "({$faq->view_count} vues)\n\n";
            }
        }

        return Response::text($content);
    }
}
