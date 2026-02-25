<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
{
    //si la table est vide le premier sera admin
    $isFirstUser = User::count() == 0;

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $isFirstUser ? 'admin' : 'membreGeneral',
    ]);

    return redirect()->route('login');
}
}
