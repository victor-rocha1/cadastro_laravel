@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pesquisar Cadastro</h2>

    <form method="GET" action="{{ route('home') }}">

        @csrf
        <input type="hidden" name="acao" id="acao" value="">

        <div class="d-flex mb-4">
            <button type="submit" class="btn btn-primary me-2" onclick="document.getElementById('acao').value='listar';">
                Listar todos os cadastros
            </button>
        </div>

        <div class="mb-3">
            <label for="pesquisar" class="form-label">Pesquisar por nome ou CPF:</label>
            <input type="text" id="pesquisar" name="pesquisar" class="form-control" placeholder="Digite o nome ou CPF" oninput="formatarCPF(event)">
        </div>

        <button type="submit" class="btn btn-success w-100" onclick="document.getElementById('acao').value='pesquisar';">
            Pesquisar
        </button>
    </form>

    @if (isset($erro))
    <div class="alert alert-danger mt-4">
        {{ $erro }}
    </div>
    @elseif (!is_null($pessoas))
    @if (count($pessoas) > 0)
    <div class="mt-4">
        @foreach ($pessoas as $pessoa)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $pessoa->nome }}</h5>
                <p class="card-text"><strong>E-mail:</strong> {{ $pessoa->email }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>Nenhuma pessoa encontrada para: {{ request()->input('pesquisar') }}</p>
    @endif
    @endif

    <a href="{{ route('cadastro.pessoa') }}" class="btn btn-link">Realizar Novo Cadastro</a>
</div>
@endsection