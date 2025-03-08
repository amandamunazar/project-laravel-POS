<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index()
    {
        $pemasoks = Pemasok::all();
        return view('pemasok.index', compact('pemasoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'email' => 'required|email|unique:pemasok,email',
        ]);

        Pemasok::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);
        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pemasok = Pemasok::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'email' => 'required|email|unique:pemasok,email,' . $id,
        ]);

        $pemasok->update($request->all());
        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pemasok::findOrFail($id)->delete();
        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil dihapus!');
    }
}
