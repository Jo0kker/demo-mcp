<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Technique', 'Facturation', 'Compte', 'Général', 'Sécurité'];

        return [
            'question' => fake()->sentence() . '?',
            'answer' => fake()->paragraph(3),
            'category' => fake()->randomElement($categories),
            'is_published' => fake()->boolean(90),
            'view_count' => fake()->numberBetween(0, 1000),
        ];
    }
}
