<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [
                    'image' => 'https://iili.io/dBcuTRj.jpg',
                    'title' => 'black panther',
                    'capital' => '100000',
                    'price' => '130000',
                    'category_id' => 1,
                    'weight' => '500',
                    'description' => "In The Dark I'm King!",
                ],
                [
                    'image' => 'https://iili.io/dBcuxUu.jpg',
                    'title' => 'vpolv',
                    'capital' => '100000',
                    'price' => '130000',
                    'category_id' => 1,
                    'weight' => '500',
                    'description' => "PEOPLE SHOULDN'T BE AFRAID OF THEIR GOVERNMENT.",
                ],

            ];
        foreach ($data as $item) {
            // Upload gambar dari URL ke folder storage
            try {
                $imageContents = file_get_contents($item['image']);
                $imageName = basename($item['image']);
            } catch (\Exception $e) {
                // Gunakan fake image jika gagal
                $fakeImage = 'https://fakeimg.pl/350x200/?text=NO_IMAGE&font=lobster';
                $imageContents = file_get_contents($fakeImage);
                $imageName = 'fake-'.uniqid().'.png';
            }

            $storagePath = 'images/'.$imageName;
            Storage::disk('public')->put($storagePath, $imageContents);

            // Buat record produk di database
            $product = Product::create([
                'category_id' => $item['category_id'],
                'title' => $item['title'],
                'capital' => $item['capital'],
                'price' => $item['price'],
                'quantity' => rand(10, 99),
                'image' => $storagePath,
                'weight' => $item['weight'],
                'description' => $item['description'],
            ]);

            $type = ['XXXL', 'XXL', 'XL', 'XL', 'L', 'M', 'S', 'XS'];
            foreach ($type as $variant) {
                Variant::create([
                    'product_id' => $product->id,
                    'type' => $variant,
                    'stock' => rand(10, 100),
                ]);
            }

            $this->command->info('Tambah Produk '.$product->title);
        }
    }
}
