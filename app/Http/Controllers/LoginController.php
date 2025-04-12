<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Username atau password salah.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect sesuai role
        if ($user->role === 'AD') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'SU') {
            return redirect()->route('dashboard.super'); // pastikan route ini ada
        } else {
            Auth::logout(); // optional, buat logout user yang role-nya gak dikenal
            return redirect('/')->with('error', 'Role tidak dikenali.');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
