<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function landing()
    {
        return view('auth.landing');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required','string'],
            'password' => ['required']
        ]);

        $login = $data['login'];

        // Build a safe query only against columns that exist in the users table
        $query = User::query();
        $added = false;

        if (Schema::hasColumn('users', 'email')) {
            $query->where('email', $login);
            $added = true;
        }

        if (Schema::hasColumn('users', 'name')) {
            if ($added) {
                $query->orWhere('name', $login);
            } else {
                $query->where('name', $login);
                $added = true;
            }
        }

        if (Schema::hasColumn('users', 'nama')) {
            if ($added) {
                $query->orWhere('nama', $login);
            } else {
                $query->where('nama', $login);
                $added = true;
            }
        }

        if (! $added) {
            // No recognizable login columns available
            return back()->withErrors(['login' => 'Konfigurasi pengguna tidak valid'])->onlyInput('login');
        }

        $user = $query->first();

        $passwordMatches = false;
        if ($user) {
            try {
                $passwordMatches = Hash::check($data['password'], $user->password);
            } catch (\RuntimeException $e) {
                // Fallback: if hashing driver enforces bcrypt algorithm but stored
                // password uses another algorithm, attempt native verification.
                $passwordMatches = password_verify($data['password'], $user->password);
            }

            // Migration helper: if stored password appears to be plaintext (legacy),
            // accept it and immediately rehash to secure algorithm.
            if (! $passwordMatches) {
                if (is_string($user->password) && $user->password === $data['password']) {
                    // Rehash. Use a direct update if the users table doesn't have timestamps
                    $newHash = Hash::make($data['password']);
                    if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'updated_at')) {
                        $user->password = $newHash;
                        $user->save();
                    } else {
                        \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update(['password' => $newHash]);
                    }
                    $passwordMatches = true;
                }
            }
        }

        if ($user && $passwordMatches) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/shop');
        }

        return back()->withErrors(['login' => 'Credential tidak cocok'])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:buyer,pegawai'
        ]);

        // Build attributes dynamically depending on users table schema
        $attributes = [
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        // name vs nama
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'nama')) {
            $attributes['nama'] = $data['name'];
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'name')) {
            $attributes['name'] = $data['name'];
        }

        // role vs peran
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'peran')) {
            $attributes['peran'] = $data['role'] === 'pegawai' ? 'Pegawai' : 'Pembeli';
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'role')) {
            $attributes['role'] = $data['role'] === 'pegawai' ? 'seller' : 'buyer';
        }

        $user = User::create($attributes);

        Auth::login($user);
        return redirect('/shop');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
