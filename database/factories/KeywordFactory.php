<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keyword>
 */
class KeywordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => fake()->word(),
            'file_name' => 'tmp',
            'adwords' => fake()->randomNumber(3),
            'links' => fake()->randomNumber(2),
            'results' => 'About ' . fake()->randomNumber(5) . ' results (0.33 seconds)',
            'html' => fake()->paragraph(),
        ];
    }
}
