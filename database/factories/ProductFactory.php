<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'information' => fake()->realText,
            'price' => fake()->numberBetween(1, 100000),
            'sort_order' => fake()->numberBetween(1, 100),
            'is_selling' => fake()->boolean,
            'shop_id' => fake()->numberBetween(1, 2),
            'secondary_category_id' => fake()->numberBetween(1, 6),
            'image1_id' => fake()->numberBetween(1, 6),
            'image2_id' => fake()->numberBetween(1, 6),
            'image3_id' => fake()->numberBetween(1, 6),
            'image4_id' => fake()->numberBetween(1, 6),
            'created_at' => fake()->datetime(),
        ];
    }
}
