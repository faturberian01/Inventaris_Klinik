<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cabang;
use App\Models\History;
use App\Models\NotaIntern;
use App\Models\Perusahaan;
use App\Models\Product;
use App\Models\Produk;
use App\Models\Stock;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        Product::factory(100)->create();
        Product::factory(5)->create();

        $productIds = Product::pluck('id');

        foreach ($productIds as $productId) {
            for ($i = 0; $i < random_int(4, 10); $i++) {
                Stock::create([
                    'product_id' => $productId,
                    'quantity' => random_int(1, 1000),
                    'expired_date' => fake()->dateTimeBetween('-1 month', '2 years')
                ]);
            }
        }

        for ($i = 0; $i < 100; $i++) {
            History::create([
                'product_id' => $productIds->random(1)->first(),
                'date' => fake()->dateTimeBetween('-1 month'),
                'quantity' => fake()->numberBetween(10, 1000),
                'total' => fake()->numberBetween(100000, 10000000),
            ]);
        }
    }
}
