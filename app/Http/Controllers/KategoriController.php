<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
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
    public function store(HttpRequest $request)
    {
        $request->validate([
            'name' => 'required|string',
            // 'deskripsi' => 'required|string'
        ]);

        $kategori = Kategori::create([
            'name' => $request->name,
            // 'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('kategori.index', compact('kategori'))->with('success', 'Data Berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        // $kategori = Kategori::findOrFail($kategori);
        // return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        // ]);

        // $kategori = Kategori::findOrFail($kategori);
        // $kategori->update([
        //     'name' => $request->name,
        // ]);

        // return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        //
    }
}
