@extends('layouts.app')

@section('title', 'Cadastro de Usuário')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Criar Conta</h3>
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Digite seu nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirme sua senha" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">Criar Conta</button>
                        </div>
                    </form>
                    @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }} <a href="{{ route('login') }}">Clique aqui para fazer login</a>.
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="mb-0">Já tem uma conta? <a href="{{ route('login') }}">Faça login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection