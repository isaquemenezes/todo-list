@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Cadastrar Novo Usuário</h2>

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

    {{-- <form action="{{ route('admin.users.store') }}" method="POST"> --}}
        <form action="">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome*</label>
            <input type="text" name="name" class="form-control" required minlength="3" maxlength="200" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail*</label>
            <input type="email" name="email" class="form-control" required maxlength="200" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha*</label>
            <input type="password" name="password" class="form-control" required minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}">
            <div class="form-text">Mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos.</div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status*</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
