<?php
namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefaUsuarioController extends Controller
{
    public function edit(Tarefa $tarefa)
    {
        if ($tarefa->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para gerenciar- esta tarefa.');
        }

        $usuarios = User::all();
        $usuariosVinculados = $tarefa->usuarios->pluck('id')->toArray();


        if (!in_array($tarefa->responsavel_id, $usuariosVinculados)) {
            $usuariosVinculados[] = $tarefa->responsavel_id;
        }

        return view('tarefas.gerenciar-usuarios',
        compact(
            'tarefa',
            'usuarios',
            'usuariosVinculados'
        ));



    }

    public function update(Request $request, Tarefa $tarefa)
    {

        if ($tarefa->responsavel_id !== Auth::id()) {
            abort(
                403,
                'Você não tem permissão para atualizar os usuários desta tarefa.'
            );
        }

        $tarefa->usuarios()->sync($request->usuarios ?? []);

        return redirect()->route('tarefas.index')
        ->with('success', 'Usuário (s) vinculado (s) à tarefa com sucesso!');

    }
}
