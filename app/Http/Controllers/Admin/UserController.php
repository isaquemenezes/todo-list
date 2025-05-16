<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\{
    UpdateUserRequest,
    StoreUserRequest

};

use App\Models\User;
use Illuminate\Support\Facades\Auth;



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
    public function store(StoreUserRequest $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'is_admin' => false,
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

    public function update(UpdateUserRequest $request, User $usuario)
    {

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
        $usuario = User::findOrFail($id);

        $relacionadoComoResponsavel = $usuario->tarefasResponsaveis()->exists();
        $relacionadoComoVinculado = $usuario->tarefasVinculadas()->exists();

        if ($relacionadoComoResponsavel || $relacionadoComoVinculado) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Não é possível remover o usuário. Ele está vinculado a uma ou mais tarefas.');
        }

        $usuario->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário removido com sucesso!');

    }

    public function perfil()
    {
        $usuario = Auth::user();
        return view('usuario.index', compact('usuario'));
    }

}
