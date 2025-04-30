<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Decal'],
            ['name' => 'Sticker Cutting'],
            ['name' => 'Vinyl'],
            ['name' => 'Aksesoris'],
        ];


        foreach ($categories as $category) {
            Category::insert($category);
        }
    }
}
