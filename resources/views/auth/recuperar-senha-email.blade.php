@extends('layouts.head')

@section('title', 'Recuperar Acesso')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="min-width: 350px;">
        <h3 class="text-center mb-4">Recuperar Acesso</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('senha.email.verificar') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Digite seu e-mail</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Continuar</button>
            </div>
        </form>
    </div>
</div>
@endsection
