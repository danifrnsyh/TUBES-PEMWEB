<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'buyer']);
    }

    // Dashboard pembeli
    public function dashboard()
    {
        $user = auth()->user();
        $totalOrders = $user->orders()->count();
        $pendingOrders = $user->orders()->where('status', 'pending')->count();
        $completedOrders = $user->orders()->where('status', 'completed')->count();
        $totalSpending = $user->orders()->where('status', 'completed')->sum('total_price');

        $recentOrders = $user->orders()->with('property', 'seller')->latest()->take(5)->get();

        return view('buyer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpending',
            'recentOrders'
        ));
    }
}
