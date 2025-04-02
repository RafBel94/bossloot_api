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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'category' => $this->faker->word(),
            'model' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 1),
            'quantity' => $this->faker->randomNumber(2),
            'featured' => $this->faker->boolean(),
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png',
        ];
    }
}
