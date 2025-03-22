<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\DetailPembelian;
use App\Models\Pemasok;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PembelianController extends Controller
{
    public function pembelian()
    {
        $pembelian = Pembelian::with('user', 'detail_pembelian.produk')->get();

        return view('pembelian.index', compact('pembelian'));
    }

    public function createPembelian()
    {
        return view('pembelian.create');
    }
    public function searchPembelian(Request $request)
    {
        $query = trim($request->input('q'));

        Log::info("Query Barang: " . ($query ?: 'NULL')); // Debugging log

        if ($query === '') {
            return response()->json([]); // Jangan kembalikan data jika query kosong
        }
        $items = Produk::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('kode', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($items);
    }


    public function searchPemasok(Request $request)
    {
        $query = trim($request->input('q'));
        $results = Pemasok::where('nama', 'like', "%{$query}%")
            ->get();
        return response()->json($results);
    }

    public function storePembelian(Request $request)
    {
        $request->validate([
            'id_pemasok' => 'required|exists:pemasok,id',
            'product_id' => 'required|array',
            'product_id.*' => 'required',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_beli' => 'required|array',
            'harga_beli.*' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        Pembelian::create([
            'kode_masuk' => 'M' . strtoupper(Str::random(8)),
            'tanggal_masuk' => now(),
            'id_pemasok' => $request->id_pemasok,
            'user_id' => $user_id
        ]);

        $pembelian = Pembelian::latest('id')->first();
        try {
            foreach ($request->product_id as $index => $product_id) {
                $sub_total = $request->harga_beli[$index] * $request->jumlah[$index];
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'product_id' => $product_id,
                    'harga_beli' => $request->harga_beli[$index],
                    'jumlah' => $request->jumlah[$index],
                    'sub_total' => $sub_total,
                ]);

                // Update stock in Barang table
                $barang = Produk::find($product_id);
                if ($barang) {
                    $barang->stok += $request->jumlah[$index];
                    $barang->save();
                }
            }

            return redirect()->route('pembelian')->with('success', 'Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pembelian: ' . $e->getMessage()]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = Pembelian::with(['pemasok', 'user', 'detail_pembelian.produk'])->latest()->get();
        return view('LaporanPembelian.index', compact('pembelian'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembelianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        return view('pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'id_pemasok' => 'required|exists:pemasok,id',
        ]);

        $pembelian->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_pemasok' => $request->id_pemasok,
        ]);

        return redirect()->route('pembelian')->with('success', 'Pembelian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect()->route('pembelian')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function exportPdf()
    {
        $pembelian = Pembelian::with(['pemasok', 'user', 'detail_pembelian.produk'])->latest()->get();

        $pdf = Pdf::loadView('LaporanPembelian.pdf', compact('pembelian'))->setPaper('a4', 'landscape');

        return $pdf->download('LaporanPembelian.pdf');
    }
}
