<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomPasswordResetController extends Controller
{
    public function formEmail()
    {
        return view('auth.recuperar-senha-email');
    }

    public function verificarEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'E-mail não encontrado.']);
        }

        return redirect()->route('senha.nova.form', $user->id);
    }

    public function formNovaSenha(User $user)
    {
        return view('auth.nova-senha', compact('user'));
    }

    public function salvarNovaSenha(Request $request, User $user)
    {
        $request->validate([
            'nova_senha' => 'required|min:8|confirmed'
        ]);

        $user->password = Hash::make($request->nova_senha);
        $user->save();

        return redirect()->route('login')->with('success', 'Senha atualizada com sucesso! Faça login.');
    }
}
