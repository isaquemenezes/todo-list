<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{
    PasswordUpdateUserLogoutRequest,
    PasswordResertRequest
};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
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

    public function salvarNovaSenha(PasswordUpdateUserLogoutRequest $request, User $user)
    {

        $user->password = Hash::make($request->nova_senha);
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Senha atualizada com sucesso! Faça login.');
    }

    public function formSenhaUsuarioLogado()
    {
        $user = Auth::user();
        return view('auth.atualizar-senha', compact('user'));
    }


    public function salvarSenhaUsuarioLogado(PasswordResertRequest $request)
    {

        /** @var User $user */
        $user = Auth::user();

        if (auth()->id() !== $user->id) {
            abort(403, 'Acesso não autorizado!');
        }

        $user->password = Hash::make($request->nova_senha);
        $user->save();

        return redirect()->route('perfil.senha.form')
            ->with('success', 'Senha atualizada com sucesso!');
    }
}
