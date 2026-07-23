<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'subtitle' => fake()->boolean(50) ? fake()->sentence(6) : null,
            'publication_year' => fake()->year(),
            'isbn' => fake()->isbn13(),
            'quantity' => fake()->numberBetween(1, 5),
            'number_of_pages' => fake()->numberBetween(50, 900),
            'cutter_code' => fake()->bothify('?###?'),
            'description' => fake()->paragraph(),
            // Associações de chave estrangeira preparadas
            'publisher_id' => Publisher::factory(),
            'theme_id' => Theme::factory(),
        ];
    }
}
