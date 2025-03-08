<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with('kategori')->paginate(10);
        $kategoris = Kategori::all();
        return view('produk.index', compact('produk', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        return view('produk.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|integer',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    public function searchBarang(Request $request)
    {
        $query = $request->query('query');
        $barang = Produk::where('nama', 'LIKE', "%{$query}%")->get();

        return response()->json($barang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('produk', 'public');

            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->gambar = $gambarPath;
        }

        // Update data produk
        $produk->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
