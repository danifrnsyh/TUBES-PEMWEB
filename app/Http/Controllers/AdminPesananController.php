<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index()
    {
        $orders = Pesanan::orderBy('created_at','desc')->paginate(20);
        return view('pegawai.orders.index', compact('orders'));
    }

    public function show(Pesanan $order)
    {
        return view('pegawai.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Pesanan $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->status = $request->input('status');
        $order->save();
        return back()->with('success', 'Status pesanan diperbarui');
    }
}
