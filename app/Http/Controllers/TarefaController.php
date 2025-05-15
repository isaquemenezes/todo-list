<?php
namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        // $tarefas = Tarefa::where('user_id', operator: auth()->id())->latest()->get();
        // $tarefas = Tarefa::all();
        // return view('tarefas.index', compact('tarefas'));
        // $query = Tarefa::with('usuarios')->whereHas('usuarios', function ($q) {
        //     $q->where('users.id', auth()->id());


        // });

        /*
        $query = Tarefa::with('usuarios')->whereHas('usuarios as u', function ($q) {
            $q->where('u.id', auth()->id());
        });

        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('usuario_id')) {
            $query->whereHas('usuarios', function ($q) use ($request) {
                $q->where('users.id', $request->usuario_id);

            });
        }

        $tarefas = $query->get();
        $todosUsuarios = User::all(); // para preencher o filtro

        return view('tarefas.index', compact('tarefas', 'todosUsuarios'));


        $query = Tarefa::where('responsavel_id', auth()->id());

        if ($request->filled('titulo')) {
            $query->where('tarefas.titulo', 'ilike', '%' . $request->titulo . '%'); // 'ilike' no PostgreSQL para case-insensitive
        }

        if ($request->filled('status')) {
            $query->where('tarefas.status', $request->status);
        }

        if ($request->filled('usuario_id')) {
            $query->whereHas('usuarios', function ($q) use ($request) {
                $q->where('users.id', $request->usuario_id);
            });
        }

        $tarefas = $query->get();
        $todosUsuarios = User::all();

        return view('tarefas.index', compact('tarefas', 'todosUsuarios'));


        $query = Tarefa::where('responsavel_id', auth()->id());

        if ($request->filled('titulo')) {
            $query->where('titulo', 'ilike', '%' . $request->titulo . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Só use esse trecho se ainda houver relação many-to-many
        if ($request->filled('usuario_id')) {
            $query->whereHas('usuarios', function ($q) use ($request) {
                $q->where('users.id', $request->usuario_id);
            });
        }

        $tarefas = $query->get();
        $todosUsuarios = User::all();

        return view('tarefas.index', compact('tarefas', 'todosUsuarios'));


        $query = Tarefa::query();

        // Aplica restrição padrão apenas se não houver filtro por usuario_id
        if (!$request->filled('usuario_id')) {
            $query->where(function ($q) {
                $q->where('responsavel_id', auth()->id())
                ->orWhereHas('usuarios', function ($q) {
                    $q->where('users', auth()->id());
                });
            });
        }

        // Filtros
        if ($request->filled('titulo')) {
            $query->where('titulo', 'ilike', '%' . $request->titulo . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('usuario_id')) {
            $query->where('responsavel_id', $request->usuario_id)
                ->orWhereHas('usuarios', function ($q) use ($request) {
                    $q->where('users', $request->usuario_id);
                });
        }

        $tarefas = $query->get();
        $todosUsuarios = User::all();

        return view('tarefas.index', compact('tarefas', 'todosUsuarios'));

         */


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
        // $tarefas = $query->paginate(3);

         $todosUsuarios = User::all();

         return view('tarefas.index', compact('tarefas', 'todosUsuarios'));




    }
    public function create()
    {
        return view('tarefas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|min:3|max:255',
            'descricao' => 'nullable|string|max:500',
            'status' => 'required|in:pendente,concluida',

        ]);

        Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
            'column_extra'=> null,
            'responsavel_id' => Auth::id(),
            // 'user_id' => 2,
        ]);

        return redirect()->route('tarefas.create')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Tarefa $tarefa)
    {
        // $this->authorize('update', $tarefa); // Proteção (se quiser usar policies)
        return view('tarefas.edit', compact('tarefa'));
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $request->validate([
            'titulo' => 'required|string|min:3|max:255',
            'descricao' => 'nullable|string|max:500',
            'status' => 'required|in:pendente,concluida',
        ]);

        // $this->authorize('update', $tarefa); // Proteção (opcional)

        $tarefa->update($request->only('titulo', 'descricao', 'status'));

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Tarefa $tarefa)
    {
        // $this->authorize('delete', $tarefa); // Proteção (opcional)

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
