<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'created_by' => $this->faker->numberBetween(1, 3),
            'created_at' => now(),
            'updated_by' => null,
        ];
    }
}

