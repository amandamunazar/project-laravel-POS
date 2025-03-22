<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPembelianFactory> */
    use HasFactory;

    protected $table = 'detail_pembelian';

    protected $fillable = ['id_pembelian', 'product_id', 'harga_beli', 'jumlah', 'sub_total'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'id');
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id');
    }
}
