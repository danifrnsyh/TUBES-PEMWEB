<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) return redirect('/');

        if ($user->isPegawai()) {
            $data = [
                'totalProducts'    => Produk::count(),
                'totalOrders'      => Pesanan::count(),
                'pendingShipment'  => Pesanan::where('status', 'proses')->count(),
                'completedOrders' => Pesanan::where('status', 'selesai')->count(),
            ];
        } else {
            // Buyer Perspective
            $data = [
                'totalOrders'    => $user->pesanans()->count(),
                'pendingOrders'  => $user->pesanans()->where('status', 'pending')->count(),
                'shippingOrders' => $user->pesanans()->where('status', 'dikirim')->count(),
            ];
        }

        return view('dashboard.index', $data);
    }
}
