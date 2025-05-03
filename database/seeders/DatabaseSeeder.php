<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(10)->create();
        \App\Models\Bank::factory(3)->create();
        \App\Models\User::factory(20)->create();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
        ]);

        Artisan::call('rajaongkir:seed');

        \App\Models\Shop::create([
            'name' => 'CABERACER',
            'province_id' => 8,
            'city_id' => 156,
            'details' => '9J3Q+QQX, Lkr. Sel., Kec. Jambi Sel., Kota Jambi, Jambi 36127.',

        ]);
    }
}
