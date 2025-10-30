<?php

namespace App\Mcp\Resources;

use App\Models\Faq;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class FaqCsvResource extends Resource
{
    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        Export complet des FAQs au format CSV.
        Idéal pour l'import dans Excel, Google Sheets ou autres outils d'analyse.
    MARKDOWN;

    /**
     * The resource's URI.
     */
    protected string $uri = 'faqs://csv';

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $faqs = Faq::published()
            ->orderBy('category')
            ->orderBy('question')
            ->get();

        // CSV Header
        $csv = "ID,Catégorie,Question,Réponse,Vues,Date de création\n";

        foreach ($faqs as $faq) {
            $category = $faq->category ?: 'Sans catégorie';
            $question = $this->escapeCsv($faq->question);
            $answer = $this->escapeCsv($faq->answer);
            $views = $faq->view_count;
            $date = $faq->created_at->format('Y-m-d H:i:s');

            $csv .= "{$faq->id},{$category},{$question},{$answer},{$views},{$date}\n";
        }

        return Response::text($csv, 'text/csv');
    }

    /**
     * Escape CSV values properly.
     */
    private function escapeCsv(string $value): string
    {
        // Si la valeur contient une virgule, guillemet ou retour ligne, on l'entoure de guillemets
        if (str_contains($value, ',') || str_contains($value, '"') || str_contains($value, "\n")) {
            // Échapper les guillemets en les doublant
            $value = str_replace('"', '""', $value);
            return "\"{$value}\"";
        }

        return $value;
    }
}
