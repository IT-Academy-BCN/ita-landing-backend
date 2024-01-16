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

        foreach ($locales as $language) {
            $data[$language] = [
                'title' => fake($language)->sentence,
                'description' => fake($language)->paragraph,
            ];
        }

        return $data;
    }
}
