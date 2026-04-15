<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Show the edit profile form
   // public function edit()
   // {
       // return view('edit-profile');
   // }

    // Handle the update
    public function update(Request $request)
    {
        $user = Auth::user();
    
        $validated = $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);
    
        $user->update([
            'full_name' => $validated['name'],  
            'email'     => $validated['email'],
        ]);
    
        return redirect()->route('edit-profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
            // 'confirmed' automatically checks 'password_confirmation' field
        ]);

        $user = Auth::user();

        // ✅ Verify current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // ✅ Update with hashed new password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Password updated successfully!');
    }
}
