@extends('layouts.app')

@section('title', 'Minhas Tarefas')

@section('content')
<div class="container mt-4">
    <h2>Minhas Tarefas</h2>

    @if(session('success') || session('error'))
        <div id="flash-message" class="alert alert-dismissible fade show alert-{{ session('success') ? 'success' : 'danger' }}" role="alert">
            {{ session('success') ?? session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <a href="{{ route('tarefas.create') }}" class="btn btn-primary mb-3">Nova Tarefa</a>

    <form method="GET" action="{{ route('tarefas.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="titulo" class="form-control" placeholder="Pesquisar por título"
                    value="{{ request('titulo') }}">
            </div>

            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">-- Filtrar por status --</option>
                    <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="concluida" {{ request('status') === 'concluida' ? 'selected' : '' }}>Concluída</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="usuario_id" class="form-control">
                    <option value="">-- Filtrar por pessoa --</option>
                    @foreach ($todosUsuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>

            <div class="col-md-1">
                <a href="{{ route('tarefas.index') }}" class="btn btn-secondary w-100">Limpar</a>
            </div>

        </div>
    </form>


    @if($tarefas->isEmpty())
        <p>Você ainda não cadastrou nenhuma tarefa.</p>
    @else
        <table class="table table-bordered" id="tabela-tarefas">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->titulo }}</td>
                    <td>{{ $tarefa->descricao }}</td>
                    <td>
                        @if ($tarefa->status === 'pendente')
                            <span class="badge bg-warning text-dark">Pendente</span>
                        @elseif ($tarefa->status === 'concluida')
                            <span class="badge bg-success">Concluída</span>
                        @endif
                    </td>


                    <td>
                        <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <!-- Botão que abre o modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal-{{ $tarefa->id }}">
                            Excluir  {{$tarefa->id}}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="confirmarExclusaoModal-{{ $tarefa->id }}" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel-{{ $tarefa->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="confirmarExclusaoModalLabel-{{ $tarefa->id }}">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza de que deseja excluir a tarefa <strong>#{{ $tarefa->titulo }}</strong> ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sim, excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if ($tarefa->status !== 'concluida' )
                            <form
                                action="{{ route('tarefas.concluir', $tarefa->id) }}"
                                method="POST"
                                style="display:inline;"
                            >
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm">Concluir</button>
                            </form>
                        @endif

                        @if ($tarefa->responsavel_id === Auth::id())
                            <a
                                href="{{ route('tarefas.gerenciar-usuarios.edit', $tarefa->id) }}"
                                class="btn btn-info btn-sm"
                            >Gerenciar Usuários</a>
                        @endif


                    </td>



                </tr>
                @endforeach

            </tbody>
        </table>

    @endif






</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Inicialização do DataTable -->
<script>
    $(document).ready(function() {
        $('#tabela-tarefas').DataTable({
            searching: false,
            language: {
                info: "Exibindo _START_ até _END_ de _TOTAL_ tarefas",
                infoEmpty: "Nenhuma tarefa encontrada",
                infoFiltered: "(filtrado de _MAX_ tarefas no total)",
                lengthMenu: "Mostrar _MENU_ tarefas por página",
                zeroRecords: "Nenhum resultado encontrado",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Próxima",
                    previous: "Anterior"
                },
            },
            pagingType: 'simple_numbers',
            lengthMenu: [5, 10, 25, 50],
            pageLength: 5
        });
    });
</script>

<script>
document.querySelector('input[name="titulo"]').addEventListener('input', function() {
    document.querySelector('select[name="status"]').selectedIndex = 0;
    document.querySelector('select[name="usuario_id"]').selectedIndex = 0;
});

document.querySelector('select[name="status"]').addEventListener('change', function() {
    document.querySelector('input[name="titulo"]').value = '';
    document.querySelector('select[name="usuario_id"]').selectedIndex = 0;
});

document.querySelector('select[name="usuario_id"]').addEventListener('change', function() {
    document.querySelector('input[name="titulo"]').value = '';
    document.querySelector('select[name="status"]').selectedIndex = 0;
});
</script>



@endsection
