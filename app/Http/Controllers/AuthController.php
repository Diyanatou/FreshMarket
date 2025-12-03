<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated=$request->validate([
                'nom' =>'required|String|max:255',
                'prenom' =>'required|String|max:255',
                'email'  =>'required|email|unique:users,email',
                'password'  =>'required|String|min:6|confirmed',  
        ]);
        User::create([
                'nom' => $validate['nom'],
                'prenom' => $validate['prenom'],
                'email'  => $validate['email'],
                'password'  => Hash::make($validate['password']), 
        ]);
        return redirect()->route()->with('success', 'Compte cree avec success!');
    }
   

    public function login(Request $request)
    {
        $credentials = $request->validate([
             'email'  =>'required|email',
            'password'  =>'required|String',   
        ]);
        $user =User::where('email', $request->email)->first();

        if(!$user){
            return back()->withErrors([
              'email'  =>'les informations d\'identification sont incorrect.',  
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

        $request->session()->put('user_id',$user->id);
        $request->session()->put('user_email',$user->email);
        $request->session()->regenerate('user_role',$user->role);

        return redirect()->intended('');
    }


}

