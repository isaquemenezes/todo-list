@extends('layouts.app')

@section('title', 'Gerenciar Usuários da Tarefa')

@section('content')
<div class="container">
    <h2>Gerenciar usuários da tarefa: <strong>{{ $tarefa->titulo }}</strong></h2>

    <form action="{{ route('tarefas.gerenciar-usuarios.update', $tarefa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Usuários envolvidos:</label>
            <p class="text-muted">Desmarque usuários para removê-los da tarefa.</p>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <div class="row">
                @foreach ($usuarios as $user)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="usuarios[]"
                                value="{{ $user->id }}"
                                id="usuario_{{ $user->id }}"
                                {{ in_array($user->id, $usuariosVinculados) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="usuario_{{ $user->id }}">
                                {{ $user->name }}
                                @if ($user->id === $tarefa->responsavel_id)
                                    <span class="badge bg-primary">Autor (a) </span>
                                @endif
                            </label>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('tarefas.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
