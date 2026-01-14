<?php

use App\Models\User;

$users = User::select('id', 'name', 'email', 'role', 'peran')->get();
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, Peran: {$user->peran}\n";
}
