<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            $response = Http::get('https://fakestoreapi.com/products');

            $data = $response->json();

            foreach ($data as $item) {
                $imageName = basename($item['image']);

                $product = Product::create([
                    'category_id' => Category::all()->random()->id,
                    'title' => $item['title'],
                    'price' => rand(10000, 99999),
                    'quantity' => rand(1, 100), // Atur jumlah sesuai kebutuhan
                    'image' => 'public/images/' . $imageName,
                    'weight' => rand(100, 999),
                    'description' => $item['description'],
                ]);

                $imageUrl = $item['image'];
                $imageData = file_get_contents($imageUrl);
                Storage::put('public/images/' . $imageName, $imageData);
                $this->command->info('Tambah Produk ' . $product->title);
            }
        } catch (\Exception $e) {
            $this->command->error('Error fetching data from API. Running ProductFactory instead.');
            $this->runProductFactory();
        }
    }
    private function runProductFactory(): void
    {
        Artisan::call('db:seed', ['--class' => ProductFactory::class]);
        $this->command->info('ProductFactory executed successfully.');
    }
}
