<?php

namespace Database\Factories;

use App\Models\Snippet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Step>
 */
class StepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'snippet_id' => Snippet::all()->random()->id,
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'order' => rand(1, 10),
        ];
    }
}
