@extends('layouts.head')

@section('title', 'Recuperar Senha')

@section('content')


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="min-width: 350px;">
        <h3>Definir Nova Senha</h3>

        <form method="POST" action="{{ route('senha.nova.salvar', $user->id) }}">
            @csrf
            <div class="form-group">
                <label>Nova Senha</label>
                <input type="password" name="nova_senha" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirmar Nova Senha</label>
                <input type="password" name="nova_senha_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-success mt-2">Salvar Nova Senha</button>
        </form>
    </div>
</div>
@endsection
