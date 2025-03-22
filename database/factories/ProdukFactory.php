<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = DB::table('kategori')
            ->inRandomOrder()
            ->select('id')
            ->first();
            
        $pemasok = DB::table('pemasok')
            ->inRandomOrder()
            ->select('id')
            ->first();

        return [
            'kode' => sprintf('%08d', fake()->unique()->numberBetween(1, 999999)),
            'kategori_id' => $data->id,
            'nama' => fake()->randomElement(['Minyak', 'Mie', 'Eskrim', 'Ayam']),
            'stok' => fake()->numberBetween(10, 100), // Stok antara 10 - 100
            'harga' => fake()->randomFloat(0, 5000, 50000), // Harga antara 5.000 - 50.000

        ];
    }
}
