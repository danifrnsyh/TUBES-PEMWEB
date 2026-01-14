<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PegawaiProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('created_at','desc')->paginate(20);
        return view('pegawai.produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = KategoriProduk::all();
        return view('pegawai.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'sku' => 'required|string|unique:produk,sku',
            'harga' => 'required|numeric',
            'berat_gram' => 'nullable|integer',
            'stok' => 'required|integer',
            'kategori_id' => 'required|integer',
            'gambar_utama' => 'nullable|image|max:2048',
            'gambar_tambahan' => 'nullable|array',
            'gambar_tambahan.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama'] = $request->file('gambar_utama')->store('produk', 'public');
        }

        $data['penambah_id'] = Auth::id();
        $data['status'] = 'aktif';

        // ensure berat_gram has a value to satisfy strict DB schema
        if (!isset($data['berat_gram']) || $data['berat_gram'] === null) {
            $data['berat_gram'] = 0;
        }

        $produk = Produk::create($data);

        // Handle multiple additional images
        if ($request->hasFile('gambar_tambahan')) {
            foreach ($request->file('gambar_tambahan') as $index => $file) {
                $path = $file->store('produk', 'public');
                ProdukGambar::create([
                    'produk_id' => $produk->id,
                    'path' => $path,
                    'urutan' => $index + 1,
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('pegawai.produk.index')->with('success', 'Produk ditambahkan');
    }

    public function edit(Produk $produk)
    {
        $kategoris = KategoriProduk::all();
        return view('pegawai.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'sku' => "required|string|unique:produk,sku,{$produk->id}",
            'harga' => 'required|numeric',
            'berat_gram' => 'nullable|integer',
            'stok' => 'required|integer',
            'kategori_id' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif,habis',
            'gambar_utama' => 'nullable|image|max:2048',
            'gambar_tambahan' => 'nullable|array',
            'gambar_tambahan.*' => 'image|max:2048',
            'delete_gambar' => 'nullable|array',
            'delete_gambar.*' => 'integer',
        ]);

        if ($request->hasFile('gambar_utama')) {
            // hapus gambar lama jika ada
            if ($produk->gambar_utama && Storage::disk('public')->exists($produk->gambar_utama)) {
                Storage::disk('public')->delete($produk->gambar_utama);
            }
            $data['gambar_utama'] = $request->file('gambar_utama')->store('produk', 'public');
        }

        $produk->update($data);

        // Delete selected images
        if ($request->has('delete_gambar')) {
            foreach ($request->input('delete_gambar') as $gambarId) {
                $gambar = ProdukGambar::find($gambarId);
                if ($gambar && Storage::disk('public')->exists($gambar->path)) {
                    Storage::disk('public')->delete($gambar->path);
                }
                $gambar->delete();
            }
        }

        // Handle new additional images
        if ($request->hasFile('gambar_tambahan')) {
            $maxUrutan = $produk->gambar()->max('urutan') ?? 0;
            foreach ($request->file('gambar_tambahan') as $index => $file) {
                $path = $file->store('produk', 'public');
                ProdukGambar::create([
                    'produk_id' => $produk->id,
                    'path' => $path,
                    'urutan' => $maxUrutan + $index + 1,
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('pegawai.produk.index')->with('success', 'Produk diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return back()->with('success', 'Produk dihapus');
    }

    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_produk,nama',
            'deskripsi' => 'required|string',
        ]);

        try {
            $kategori = KategoriProduk::create($validated);
            return response()->json([
                'success' => true,
                'kategori' => $kategori,
                'message' => 'Kategori berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStock(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $produk->update(['stok' => $validated['stok']]);

        return redirect()->back()->with('success', 'Stock produk berhasil diperbarui');
    }
}
