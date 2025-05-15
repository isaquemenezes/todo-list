<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;



class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /*

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->status) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Seu usuário está inativo.',
                ]);
            }

            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.users.index');
            }

            return redirect()->route('usuario.index');
        }
    }
        */

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->route('admin.index');
        }

        return redirect()->route('usuario.index');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('auth/login');
    }
}
