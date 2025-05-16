@extends('layouts.app')

@section('title', 'Perfil do Usuário')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Perfil do Usuário</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Dados Cadastrais
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nome:</dt>
                <dd class="col-sm-9">{{ $usuario->name }}</dd>

                <dt class="col-sm-3">E-mail:</dt>
                <dd class="col-sm-9">{{ $usuario->email }}</dd>

                <dt class="col-sm-3">Tipo de Usuário:</dt>
                <dd class="col-sm-9">
                    @if(Auth::user()->is_admin)
                        <span class="badge bg-danger">Administrador</span>
                    @else
                        <span class="badge bg-secondary">Comum</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Status:</dt>
                <dd class="col-sm-9">
                    @if ($usuario->status)
                        <span class="badge bg-success">Ativo</span>
                    @else
                        <span class="badge bg-secondary">Inativo</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Cadastrado em:</dt>
                <dd class="col-sm-9">{{ $usuario->created_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('logout') }}" class="btn btn-outline-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sair da Conta
            </a>

            <a href="{{ route('perfil.senha.form') }}" class="btn btn-outline-primary">
                Atualizar Senha
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
