@extends('layouts.app')

@section('title', 'Nova Tarefa')

@section('content')
<div class="container mt-4">
    <h2>Cadastrar Nova Tarefa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tarefas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título*</label>
            <input type="text" name="titulo" class="form-control" required minlength="3" maxlength="255" value="{{ old('titulo') }}">
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" maxlength="500">{{ old('descricao') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status*</label>
            <select name="status" class="form-select" required>
                <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="concluida" {{ old('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('tarefas.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
@endsection
