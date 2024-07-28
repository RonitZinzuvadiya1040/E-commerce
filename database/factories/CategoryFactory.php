<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(200),
            'image' => $this->faker->image('public/categories', 640, 480, null, false),
            'parent_id' => $this->faker->randomElement($array = Category::pluck('id')->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
