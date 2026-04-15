<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate
        $data =$request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'accepted',
        ], [
            'name.required'      => 'Full name is required.',
            'email.required'     => 'Email address is required.',
            'email.unique'       => 'This email is already registered.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'terms.accepted'     => 'You must accept the Terms and Conditions.',
        ]);

        // 2. Insert into database
         DB::table('users')->insert([
            'id'         => Str::uuid(),
            'full_name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
      
        return redirect()->route('login')->with('success', 'Welcome! Your account has been created.');
             
    }
    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(Auth::attempt($credentials)){
           return redirect()->route('dashboard')->with('success', 'Welcome ! You have successfully logged in.');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

}
    

