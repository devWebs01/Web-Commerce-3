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
            [
                'name' => 'Makeup',
            ],
            [
                'name' => 'Skincare',
            ],
            [
                'name' => 'Hair Care',
            ],
            [
                'name' => 'Nail Care',
            ],
            [
                'name' => 'Sunscreen Family',
            ],
            [
                'name' => 'Anti Acne Family',
            ],
            [
                'name' => '5X Ceramide Family',
            ],
            [
                'name' => '2PCS Diskon Paket',
            ],
            [
                'name' => '3PCS Gift Value Sets',
            ],
            [
                'name' => '5PCS Gift Value Sets',
            ],
            [
                'name' => 'Facial Wash',
            ],
            [
                'name' => 'Toner Family',
            ],
            [
                'name' => 'Make Up',
            ],
            [
                'name' => 'New Launch',
            ],
        ];


        foreach ($categories as $category) {
            Category::insert($category);
        }
    }
}
