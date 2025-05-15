<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();

        return view('admin.users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:200',
            'email' => 'required|email|max:200|unique:users',
            'password' => [
                'required',
                'string',
                'min:8'

            ],
            'status' => 'required|boolean',

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'is_admin' => false, // Por padrão, usuários não são administradores
        ]);

        return redirect()->route(
            'admin.users.index'
            )
            ->with(
                'success',
                'Usuário criado com sucesso!'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        // dd($usuario->id);
        // $usuario = User::findOrFail($id);

        // $request->validate([
        //     'name' => 'required|string|min:3|max:200',
        //     'email' => [
        //         'required',
        //         'email',
        //         'max:200',
        //         Rule::unique('users')->ignore($usuario->id),
        //     ],
        //     'status' => 'required|boolean',
        // ]);

        // $usuario->update($request->only(['name', 'email', 'status']));

        // return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');
        $request->validate([
            'name' => 'required|string|min:3|max:200',
            'email' => ['required', 'email', 'max:200', Rule::unique('users')->ignore($usuario->id)],
            'password' => [
                'nullable', // senha opcional
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'status' => 'required|boolean',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->status = $request->status;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // $usuario = User::findOrFail($id);
        // $usuario->delete();

        // return redirect()->route('admin.users.index')
        //     ->with('success', 'Usuário removido com sucesso!');

        $usuario = User::findOrFail($id);

        // Verifica se o usuário é responsável por alguma tarefa
        $relacionadoComoResponsavel = $usuario->tarefasResponsaveis()->exists();

        // Verifica se o usuário está vinculado em tarefas (relação many-to-many)
        $relacionadoComoVinculado = $usuario->tarefasVinculadas()->exists();

        if ($relacionadoComoResponsavel || $relacionadoComoVinculado) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Não é possível remover o usuário. Ele está vinculado a uma ou mais tarefas.');
        }

        // $usuario->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário removido com sucesso!');

    }
}
