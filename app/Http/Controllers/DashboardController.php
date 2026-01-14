<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) return redirect('/');

        if ($user->isPegawai()) {
            return view('dashboard.pegawai');
        }

        return view('dashboard.buyer');
    }
}
