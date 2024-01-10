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
        $locales = (app('translatable.locales')->all());
        $language = $locales[array_rand($locales)];

        return [
            $language => [
                'title' => fake($language)->sentence,
                'description' => fake($language)->paragraph,
            ],
        ];
    }
}
