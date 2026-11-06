<?php

namespace Database\Factories;

use App\Models\StceciliasEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<StceciliasEvent> */
class StceciliasEventFactory extends Factory
{
    public function definition(): array
    {
        return ['slug' => fake()->unique()->slug(), 'title' => fake()->sentence(3), 'intro' => fake()->sentence(), 'is_visible' => true, 'starts_at' => now()->addWeek(), 'ends_at' => now()->addWeek()->addHour()];
    }
}
