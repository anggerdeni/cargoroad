<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        // Generate 20 random brands
        Brand::factory()->count(20)->create();
    }
}
