<?php

namespace Database\Factories;

use App\Models\StceciliasPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<StceciliasPage> */
class StceciliasPageFactory extends Factory
{
    public function definition(): array
    {
        return ['slug' => fake()->unique()->slug(), 'title' => fake()->sentence(3), 'intro' => fake()->sentence(), 'is_visible' => true];
    }
}
