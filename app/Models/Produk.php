<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = ['kode', 'nama', 'kategori_id', 'stok', 'harga', 'harga_jual', 'deskripsi', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'product_id', 'id');
    }

    public static function generateKodeProduk()
    {
        $prefix = 'PRD';
        $latestProduct = self::latest()->first();

        if ($latestProduct) {
            $number = (int) substr($latestProduct->kode, 3) + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
