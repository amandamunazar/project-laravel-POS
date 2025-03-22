<?php

namespace App\Exports;

use App\Models\PengajuanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;

class PengajuanBarangExport implements FromCollection
{
    public function collection()
    {
        return PengajuanBarang::all();
    }
}
