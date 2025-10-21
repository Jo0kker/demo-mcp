<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des FAQs réalistes pour la démo
        $faqs = [
            [
                'question' => 'Comment réinitialiser mon mot de passe ?',
                'answer' => 'Pour réinitialiser votre mot de passe, cliquez sur "Mot de passe oublié" sur la page de connexion. Vous recevrez un email avec un lien pour définir un nouveau mot de passe.',
                'category' => 'Compte',
                'is_published' => true,
            ],
            [
                'question' => 'Quels sont les modes de paiement acceptés ?',
                'answer' => 'Nous acceptons les cartes bancaires (Visa, Mastercard), PayPal et les virements bancaires pour les entreprises.',
                'category' => 'Facturation',
                'is_published' => true,
            ],
            [
                'question' => 'Comment contacter le support technique ?',
                'answer' => 'Notre équipe support est disponible par email à support@example.com ou via le chat en direct 24/7.',
                'category' => 'Général',
                'is_published' => true,
            ],
            [
                'question' => 'L\'application est-elle sécurisée ?',
                'answer' => 'Oui, nous utilisons le chiffrement SSL/TLS pour toutes les communications. Vos données sont stockées dans des datacenters certifiés ISO 27001.',
                'category' => 'Sécurité',
                'is_published' => true,
            ],
            [
                'question' => 'Puis-je exporter mes données ?',
                'answer' => 'Absolument ! Vous pouvez exporter vos données à tout moment depuis les paramètres de votre compte au format CSV ou JSON.',
                'category' => 'Technique',
                'is_published' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // Créer des FAQs aléatoires supplémentaires
        Faq::factory(15)->create();
    }
}
