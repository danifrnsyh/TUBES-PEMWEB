<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function create(Produk $produk)
    {
        return view('orders.create', compact('produk'));
    }

    public function store(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'alamat_kirim' => 'required|string',
            'metode_pembayaran' => 'required|in:Bayar Ditempat,Transfer',
        ]);

        $jumlah = (int)$request->input('jumlah');

        if ($jumlah > $produk->stok) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi'])->withInput();
        }

        $nomor = 'INV-' . strtoupper(Str::random(8));

        $pesanan = Pesanan::create([
            'nomor_invoice' => $nomor,
            'pembeli_id' => Auth::id(),
            'total' => $produk->harga * $jumlah,
            'status' => 'pending',
            'catatan' => $request->input('catatan',''),
            'alamat_kirim' => $request->input('alamat_kirim'),
            'ongkir' => $request->input('ongkir', 0),
            'metode_pembayaran' => $request->input('metode_pembayaran'),
        ]);

        PesananItem::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'nama_produk' => $produk->nama,
            'sku' => $produk->sku,
            'jumlah' => $jumlah,
            'harga_unit' => $produk->harga,
            'subtotal' => $produk->harga * $jumlah,
            'metode' => $pesanan->metode_pembayaran,
            'status' => 'pending',
        ]);

        // kurangi stok
        $produk->stok = max(0, $produk->stok - $jumlah);
        $produk->save();

        return redirect()->route('orders.show', ['order' => $pesanan->id])->with('success', 'Pesanan dibuat');
    }

    public function show(Pesanan $order)
    {
        return view('orders.show', ['order' => $order]);
    }

    public function indexForBuyer()
    {
        $orders = Pesanan::where('pembeli_id', Auth::id())->orderBy('created_at','desc')->paginate(12);
        return view('orders.index_buyer', compact('orders'));
    }
}
