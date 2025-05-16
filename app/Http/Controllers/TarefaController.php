<?php
namespace App\Http\Controllers;

use App\Http\Requests\Tarefa\{
    StoreTarefaRequest,
    UpdateTarefaRequest
};
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TarefaController extends Controller
{
    public function index(Request $request)
    {

        $query = Tarefa::query();

        if ($request->filled('titulo') || $request->filled('status') || $request->filled('usuario_id')) {

            if ($request->filled('titulo')) {
                $query->where('titulo', 'ilike', '%' . $request->titulo . '%');
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('usuario_id')) {
                $query->where(function ($q) use ($request) {
                    $q->where('responsavel_id', $request->usuario_id)
                    ->orWhereHas('usuarios', function ($q2) use ($request) {
                        $q2->where('users.id', $request->usuario_id);
                    });
                });
            }

        } else {

            $query->where(function ($q) {
                $q->where('responsavel_id', auth()->id())
                ->orWhereHas('usuarios', function ($q2) {
                    $q2->where('users.id', auth()->id());
                });
            });
        }



        $tarefas = $query->get();
        $todosUsuarios = User::all();

        return view('tarefas.index',
        compact(
            'tarefas',
            'todosUsuarios'
        ));




    }
    public function create()
    {
        return view('tarefas.create');
    }

    public function store(StoreTarefaRequest $request)
    {

        Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
            'column_extra'=> null,
            'responsavel_id' => Auth::id()

        ]);

        return redirect()->route('tarefas.create')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Tarefa $tarefa)
    {
        return view('tarefas.edit', compact('tarefa'));
    }

    public function update(UpdateTarefaRequest $request, Tarefa $tarefa)
    {

        $tarefa->update($request->only(
            'titulo',
            'descricao',
            'status')
        );

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Tarefa $tarefa)
    {

        $tarefa->delete();

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    public function concluir(Tarefa $tarefa)
    {

        // if (! $tarefa->usuarios->contains(auth()->id())) {
        //     abort(403, 'Você não tem permissão para concluir esta tarefa.');
        // }

        $tarefa->update([
            'status' => 'concluida'
        ]);

        return back()->with('success', 'Tarefa marcada como concluída!');
    }

}
