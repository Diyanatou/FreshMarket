<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role; 

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $roleClient = Role::where('name', 'client')->first();

        if (!$roleClient) {
            return back()->with('error', 'Le rôle client n’existe pas dans la base de données.');
        }

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_user'=> $roleClient->id,
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès !');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Les informations d’identification sont incorrectes.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    $user = Auth::user();

    // Redirection selon le rôle
    if ($user->role_user == 1) { // client
        return redirect('/client/home');
    }

    if ($user->role_user == 2) { // admin
        return redirect('/admin/dashboard');
    }

    return redirect('/');
}

    public function logout(Request $request)
    {
        $request->session()->forget([
            'user_id',
            'user_name',
            'user_email',
            'user_role'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
