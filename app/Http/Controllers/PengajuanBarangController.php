<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Exports\PengajuanBarangExport;
use Illuminate\Support\Facades\Log;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanBarang::all();
        return view('pengajuan.index', compact('pengajuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengaju' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'qty' => 'required|integer|min:1',
        ]);

        // Menggunakan updateOrCreate untuk menghindari duplikasi data
        $pengajuan = PengajuanBarang::updateOrCreate(
            ['id' => $request->id], // Jika ada ID, update. Jika tidak, insert baru.
            [
                'nama_pengaju' => $request->nama_pengaju,
                'nama_barang' => $request->nama_barang,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'qty' => $request->qty,
            ]
        );

        Log::info('Pengajuan barang ditambahkan', ['id' => $pengajuan->id, 'nama_barang' => $pengajuan->nama_barang]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan disimpan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->terpenuhi = $request->has('terpenuhi') ? 1 : 0;
        $pengajuan->save();

        Log::info('Pengajuan barang diperbarui', ['id' => $pengajuan->id, 'nama_barang' => $pengajuan->nama_barang]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        PengajuanBarang::destroy($id);

        Log::info('Pengajuan barang dihapus', ['id' => $id, 'nama_barang' => $pengajuan->nama_barang]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan dihapus!');
    }

    public function exportExcel()
    {
        return Excel::download(new PengajuanBarangExport, 'pengajuan.xlsx');
    }

    public function exportPDF()
    {
        $pengajuans = PengajuanBarang::all();
        $pdf = FacadePdf::loadView('pengajuan.pdf', compact('pengajuans'));
        return $pdf->download('pengajuan_barang.pdf');
    }

    public function toggleStatus($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->terpenuhi = !$pengajuan->terpenuhi;
        $pengajuan->save();

        $status = $pengajuan->terpenuhi ? 'terpenuhi' : 'belum terpenuhi';
        Log::notice('Status pengajuan barang diubah', ['id' => $id, 'status' => $status]);

        return redirect()->back()->with('success', 'Status pengajuan barang diperbarui');
    }
}
