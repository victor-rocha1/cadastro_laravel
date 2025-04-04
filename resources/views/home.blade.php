@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
        @auth
            <span class="txt">Bem-vindo, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-danger logout-btn">Sair</button>
            </form>
        @endauth
    </div>
</div>

@section('content')
<div class="container mt-4">
    <!-- Conteúdo principal -->
    <div class="d-flex justify-content-center">
        <div class="card col-md-6 p-4">
            <h2 class="mb-4 text-center">Pesquisar Cadastro</h2>

            <!-- Formulário de pesquisa -->
            <form method="GET" action="{{ route('home') }}">
                @csrf
                <div class="mb-3">
                    <label for="pesquisar" class="form-label fw-bold">Pesquisar por nome ou CPF:</label>
                    <input type="text" id="pesquisar" name="pesquisar" class="form-control" placeholder="Digite o nome ou CPF" oninput="mascaraCPF(event)">
                </div>
                <button type="submit" class="btn btn-info w-100">
                    <i class="fas fa-search"></i> Pesquisar
                </button>
            </form>

            @if (!is_null($pessoas))
                @if (count($pessoas) > 0)
                    <div class="mt-3">
                        @foreach ($pessoas as $pessoa)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pessoa->nome }}</h5>
                                    <p class="card-text"><strong>E-mail:</strong> {{ $pessoa->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            @if (Auth::check() && Auth::user()->is_admin)
                <form method="GET" action="{{ route('admin.listar') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 mt-5">
                        <i class="fas fa-list"></i> Listar Cadastros
                    </button>
                </form>
                <a href="{{ route('cadastro.pessoa') }}" class="btn btn-success w-100">
                    <i class="fas fa-user-plus"></i> Realizar Novo Cadastro
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .d-flex {
        display: flex;
        align-items: center; /* Alinha os itens verticalmente */
        justify-content: space-between; /* Mantém um à esquerda e outro à direita */
    }

    .txt, .logout-btn {
        font-size: 1.2rem;
        border-radius: 8px;
        padding: 8px 15px;
        height: 45px; /* Define uma altura fixa */
        display: flex;
        align-items: center;
    }

    .txt {
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .logout-btn {
        justify-content: center;
    }

    .logout-form {
        margin: 0; /* Remove qualquer margem extra no formulário */
    }
</style>
@endpush