@extends('layouts.admin')

@section('title', 'Gerenciamento de Usuários')

@section('content')

{{-- <div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message">{{ session('error') }}</div>
    @endif
</div> --}}
@if(session('success') || session('error'))
    <div id="flash-message" class="alert alert-dismissible fade show alert-{{ session('success') ? 'success' : 'danger' }}" role="alert">
        {{ session('success') ?? session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif


<h1>Gerenciamento de Usuários</h1>

<a href="{{ route('admin.users.create') }}" class="btn btn-success">+ Adicionar Usuário</a>

<table class="table table-bordered mt-3">
    <thead>
        <tr>

            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($usuarios as $usuario)
        @php $modalId = 'modalExcluirUsuario' . $usuario->id; @endphp

            <tr>

                <td>{{ $usuario->name }}</td>

                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->status ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $usuario->id) }}" class="btn btn-primary btn-sm">Editar</a>

                    <form
                        action="{{ route('admin.users.destroy', $usuario->id) }}"
                            method="POST"
                            style="display:inline-block"
                        >
                        @csrf
                        @method('DELETE')
                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $modalId }}"
                        >
                            Remover
                        </button>
                        <!-- Modal Exclusao Usuario-->
                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="modalLabel{{ $usuario->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $usuario->id }}">Confirmar Exclusão</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                Tem certeza que deseja remover o usuário <strong>{{ $usuario->name }}</strong>? Esta ação não poderá ser desfeita.
                                </div>
                                <div class="modal-footer">
                                <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Sim, remover</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                            </div>
                        </div>

                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Nenhum usuário cadastrado.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
