<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqHtmlResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Liste complète des FAQs au format HTML.
        Prêt à être affiché dans un navigateur ou intégré dans une page web.
    MARKDOWN;

    /**
     * The resource's URI.
     */
    protected string $uri = 'faqs://html';

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

        $totalCount = Faq::published()->count();

        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Base de connaissances FAQ</title>
            <style>
                body { font-family: system-ui, -apple-system, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; line-height: 1.6; color: #333; }
                h1 { color: #2563eb; border-bottom: 3px solid #2563eb; padding-bottom: 10px; }
                h2 { color: #1e40af; margin-top: 40px; border-left: 4px solid #2563eb; padding-left: 15px; }
                .faq-item { background: #f9fafb; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #60a5fa; }
                .question { font-weight: 600; font-size: 1.1em; color: #1e40af; margin-bottom: 10px; }
                .answer { color: #4b5563; margin-bottom: 10px; }
                .meta { font-size: 0.9em; color: #6b7280; }
                .stats { background: #eff6ff; padding: 15px; border-radius: 8px; margin: 20px 0; }
                hr { border: none; border-top: 1px solid #e5e7eb; margin: 30px 0; }
            </style>
        </head>
        <body>
            <h1>📚 Base de connaissances FAQ</h1>
            <div class="stats">
                <strong>Total de FAQs publiées :</strong> {$totalCount}
            </div>
        HTML;

        foreach ($faqs as $category => $categoryFaqs) {
            $categoryName = $category ?: 'Sans catégorie';
            $categoryCount = $categoryFaqs->count();

            $html .= "\n            <h2>{$categoryName} <span style=\"font-size: 0.8em; color: #6b7280;\">({$categoryCount})</span></h2>\n";

            foreach ($categoryFaqs as $faq) {
                $question = htmlspecialchars($faq->question);
                $answer = nl2br(htmlspecialchars($faq->answer));
                $views = $faq->view_count;

                $html .= <<<ITEM

                            <div class="faq-item">
                                <div class="question">❓ {$question}</div>
                                <div class="answer">{$answer}</div>
                                <div class="meta">👁️ {$views} consultation(s)</div>
                            </div>
                ITEM;
            }
        }

        $html .= <<<HTML

            <hr>
            <footer style="text-align: center; color: #9ca3af; font-size: 0.9em;">
                Généré automatiquement via MCP Resource
            </footer>
        </body>
        </html>
        HTML;

        return Response::text($html, 'text/html');
    }
}
