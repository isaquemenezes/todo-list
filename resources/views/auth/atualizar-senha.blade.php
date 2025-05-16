@extends('layouts.app')

@section('title', 'Atualizar Senha')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h4 class="mb-3 text-center">Atualizar Senha</h4>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('perfil.senha.salvar') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nova_senha" class="form-label">Nova Senha</label>
                <input type="password" name="nova_senha" id="nova_senha" class="form-control" required>
                @error('nova_senha') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>
@endsection
