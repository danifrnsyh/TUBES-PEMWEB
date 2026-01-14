<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::where('status','aktif')->orderBy('created_at','desc')->paginate(12);
        return view('products.index', compact('produks'));
    }

    public function show(Produk $produk)
    {
        return view('products.show', compact('produk'));
    }
}
