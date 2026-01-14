<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'seller']);
    }

    // Dashboard penjual
    public function dashboard()
    {
        $user = auth()->user();
        $totalProperties = $user->properties()->count();
        $totalOrders = $user->sellerOrders()->count();
        $pendingOrders = $user->sellerOrders()->where('status', 'pending')->count();
        $totalEarnings = $user->sellerOrders()->where('status', 'completed')->sum('total_price');

        $recentOrders = $user->sellerOrders()->with('buyer', 'property')->latest()->take(5)->get();
        $properties = $user->properties()->latest()->take(5)->get();

        return view('seller.dashboard', compact(
            'totalProperties',
            'totalOrders',
            'pendingOrders',
            'totalEarnings',
            'recentOrders',
            'properties'
        ));
    }

    // Lihat semua properties penjual
    public function properties()
    {
        $properties = auth()->user()->properties()->paginate(10);
        return view('seller.properties', compact('properties'));
    }
}
