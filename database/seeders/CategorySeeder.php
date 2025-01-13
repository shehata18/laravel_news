<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['technology category', 'sports category', 'fashion category'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'status'=>1,
                'created_at' => fake()->date("Y-m-d h:m:s"),
                'updated_at' => fake()->date("Y-m-d h:m:s"),
            ]);
        }
    }
}
