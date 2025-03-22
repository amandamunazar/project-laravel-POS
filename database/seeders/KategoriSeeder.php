<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Kategori;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Kategori::truncate();
        Schema::enableForeignKeyConstraints();
        $file = File::get('database/data/Kategori.json');
        $data = json_decode($file);
        foreach ($data as $item) {
            Kategori::create([
                // 'id' => $item->id,
                'name' => $item->nama_kategori,
            ]);
        }
    }
}
