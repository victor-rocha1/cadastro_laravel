@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<div class="container mt-4 d-flex justify-content-center">
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

        <!-- Exibição de resultados de pesquisa -->
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

            <!-- Exibição de erros -->
            @if (isset($erro))
                <div class="alert alert-danger mt-3">
                    {{ $erro }}
                </div>
            @endif
        @endif

        <!-- Apenas administradores podem listar e cadastrar -->
        @if (Auth::check() && Auth::user()->is_admin)
            <!-- Formulário para listar cadastros -->
            <form method="GET" action="{{ route('admin.listar') }}" class="mb-3">
                @csrf
                <input type="hidden" name="acao" id="acao" value="listar">
                <button type="submit" class="btn btn-primary w-100 mt-5">
                    <i class="fas fa-list"></i> Listar Cadastros
                </button>
            </form>

            <!-- Link para novo cadastro -->
            <a href="{{ route('cadastro.pessoa') }}" class="btn btn-success w-100">
                <i class="fas fa-user-plus"></i> Realizar Novo Cadastro
            </a>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Apenas ajustes essenciais */
    .card {
        border: none; 
        border-radius: 12px; 
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); 
    }

    .alert {
        margin-top: 1rem; /* Ajustar o espaçamento para alertas */
    }
</style>
@endpush