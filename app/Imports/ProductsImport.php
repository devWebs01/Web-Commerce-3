<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $originalUrl = $row['gambar'] ?? null;
            $imagePath = null;

            // helper untuk download dan simpan ke disk public
            $downloadAndStore = function (string $url) {
                try {
                    $resp = Http::timeout(30)->get($url);
                    if ($resp->successful()) {
                        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                        $filename = Str::random(20) . '.' . $ext;
                        $folder = 'products/images';
                        Storage::disk('public')->put("$folder/$filename", $resp->body());
                        return "$folder/$filename";
                    }
                } catch (\Exception $e) {
                    Log::warning("Download failed for $url: " . $e->getMessage());
                }
                return null;
            };

            // 1) coba download gambar asli
            if ($originalUrl && filter_var($originalUrl, FILTER_VALIDATE_URL)) {
                $imagePath = $downloadAndStore($originalUrl);
            }

            // 2) jika gagal, fallback ke fakeimg.pl
            if (!$imagePath) {
                $fakeUrl = 'https://fakeimg.pl/350x200/?text=NO_IMAGE&font=lobster';
                $imagePath = $downloadAndStore($fakeUrl)
                    // terakhir, kalau pun masih null, bisa pakai placeholder lokal
                    ?? 'defaults/default.jpg';
            }

            Product::create([
                'category_id' => $row['kategori_id'],
                'image' => $imagePath,
                'title' => $row['nama_produk'],
                'capital' => (int) $row['harga_modal'],
                'price' => (int) $row['harga_jual'],
                'weight' => (int) $row['berat'],
                'description' => $row['deskripsi'],
            ]);
        }
    }
}
