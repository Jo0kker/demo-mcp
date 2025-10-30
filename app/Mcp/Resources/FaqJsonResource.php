<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqJsonResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Liste complète des FAQs au format JSON structuré.
        Parfait pour les intégrations API et les clients qui ont besoin de données structurées.
    MARKDOWN;

    /**
     * The resource's URI.
     */
    protected string $uri = 'faqs://json';

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

        $data = [
            'total' => Faq::published()->count(),
            'categories' => $faqs->map(function ($categoryFaqs, $category) {
                return [
                    'name' => $category ?: 'Sans catégorie',
                    'count' => $categoryFaqs->count(),
                    'faqs' => $categoryFaqs->map(function ($faq) {
                        return [
                            'id' => $faq->id,
                            'question' => $faq->question,
                            'answer' => $faq->answer,
                            'view_count' => $faq->view_count,
                            'created_at' => $faq->created_at->toISOString(),
                        ];
                    })->values(),
                ];
            })->values(),
        ];

        return Response::json($data);
    }
}
