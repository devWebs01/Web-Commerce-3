<?php

namespace Database\Seeders;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;



class JsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the JSON file
        $path = public_path('products.json');

        // Check if the file exists
        if (!File::exists($path)) {
            Log::error("File not found: $path");
            return;
        }

        // Read the JSON file
        $json = File::get($path);

        // Decode JSON data to PHP array
        $data = json_decode($json, true);

        // Check if JSON decoding was successful
        if ($data === null) {
            Log::error("Error decoding JSON file: $path");
            return;
        }

        // Initialize Guzzle client
        $client = new Client();

        // Loop through the data and create entries in the database
        foreach ($data as $item) {
            try {
                // Trim spaces from the URL
                $imageUrl = trim($item['image']);
                $imageName = basename($imageUrl);
                $imagePath = 'public/images/' . $imageName;

                // Download the image using Guzzle
                $response = $client->get($imageUrl);

                if ($response->getStatusCode() !== 200) {
                    throw new Exception("Failed to download image from $imageUrl");
                }

                $imageData = $response->getBody()->getContents();

                // Save the image to storage
                Storage::put($imagePath, $imageData);

                // Buat record produk di database
                $product = Product::create([
                    'category_id' => $item['category_id'],
                    'title' => $item['title'],
                    'price' => $item['price'],
                    'quantity' => rand(10, 100), // Atur jumlah sesuai kebutuhan
                    'image' => 'images/' . $imageName, // Path without 'public/'
                    'weight' => $item['weight'],
                    'description' => $item['description'],
                ]);

                $this->command->info('Tambah Produk ' . $product->title);
            } catch (Exception $e) {
                Log::error("Error processing item: " . $e->getMessage());
            }
        }
    }
}
