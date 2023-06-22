<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Generate 20 random products
        Product::factory()->count(20)->create();
    }
}
