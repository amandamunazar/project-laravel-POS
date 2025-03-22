<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $this->call([KategoriSeede::class]);
        // Produk::factory()->count(50)->create();
        // $this->call([
        //     KategoriSeeder::class,
        // ]);
        // Menambahkan data pengguna dengan password terenkripsi menggunakan bcrypt
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'super user',
                'email' => 'qwerty@gmail.com',
                'password' => Hash::make('user'), // Menggunakan Hash::make untuk bcrypt
                'role' => 'SU',
                
            ],
            [
                'id' => '2',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'), // Menggunakan Hash::make untuk bcrypt
                'role' => 'AD',
                
            ]
        ]);
    }
}