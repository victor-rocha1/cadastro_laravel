@extends('layouts.app')

@section('title', 'Login - Sistema de Cadastro')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Login</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg">Entrar</button>
                            </div>
                        </form>
                        @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger mt-2">
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
                <p class="mb-0">Ainda não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</div>
@endsection