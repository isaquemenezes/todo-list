@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuário</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erros encontrados:</strong>
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome*</label>
            <input type="text" name="name" class="form-control" required minlength="3" maxlength="200"
                   value="{{ old('name', $usuario->name) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail*</label>
            <input type="email" name="email" class="form-control" required maxlength="200"
                   value="{{ old('email', $usuario->email) }}">
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">Senha (preencha se quiser alterar)</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                required
                minlength="8"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$"
                title="A senha deve conter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos."
            >
            <div class="form-text text-muted">
                Mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos.
            </div>
        </div>


        <div class="mb-3">
            <label for="status" class="form-label">Status*</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $usuario->status) == 1 ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ old('status', $usuario->status) == 0 ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
