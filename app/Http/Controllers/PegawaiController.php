<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::all();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        Pegawai::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
