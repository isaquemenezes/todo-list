<?php
namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        // $usuarios = User::all();
        // return view('usuarios.index', compact('usuarios'));
        // $tarefas = Tarefa::where('responsavel_id', Auth::id())->get();

        // return view('usuario.index', compact('tarefas'));

        $usuario = Auth::user();
        return view('usuario.index', compact('usuario'));
    }

    public function create()
    {
        return view('usuario.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:200',
            'email' => 'required|email|max:200|unique:users,email',
            'password' => [
                'required', 'min:8',
                'regex:/[a-z]/', 'regex:/[A-Z]/',
                'regex:/[0-9]/', 'regex:/[@$!%*#?&]/',
            ],
            'status' => 'required|boolean',
        ]);

        User::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuário criado!');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:200',
            'email' => 'required|email|max:200|unique:users,email,' . $usuario->id,
            'status' => 'required|boolean',
            'password' => 'nullable|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        $usuario->nome = $validated['nome'];
        $usuario->email = $validated['email'];
        $usuario->status = $validated['status'];
        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }
        $usuario->save();

        return redirect()->route('usuario.index')->with('success', 'Usuário atualizado!');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuario.index')->with('success', 'Usuário removido!');
    }
}
