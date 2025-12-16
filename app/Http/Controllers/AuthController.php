<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès !');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Les informations d’identification sont incorrectes.',
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);
        $request->session()->put('user_role', $user->role ?? 'user');

        return redirect('/dashboard');
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
