<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';

    protected $fillable = ['nama', 'alamat', 'no_telp', 'email'];

    public $timestamps = false;

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_pemasok', 'id');
    }
}
