<?php

namespace App\Http\Controllers;

use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = member::all();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:members',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:members,email,' . $id,
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        $member = member::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member berhasil diperbarui');
    }

    public function destroy($id)
    {
        $member = member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus');
    }
}
