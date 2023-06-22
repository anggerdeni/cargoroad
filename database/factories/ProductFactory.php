<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'brand_id' => \App\Models\Brand::factory(),
            'created_by' => $this->faker->numberBetween(1, 3),
            'created_at' => now(),
            'updated_by' => null,
        ];
    }
}
