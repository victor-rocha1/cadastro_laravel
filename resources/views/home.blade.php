@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<form method="POST" action="{{ route('home') }}">
    @csrf
    <input type="hidden" name="acao" id="acao" value="">

    <div class="consulta">
        <button type="submit" class="btn" 
                onclick="document.getElementById('acao').value='listar';">
            Listar todos os cadastros
        </button>

        <button type="submit" class="btn" style="background-color: green; color: white;" 
                onclick="document.getElementById('acao').value='alterar';">
            Alterar Dados
        </button>
    </div>

    <label for="pesquisar">Pesquisar por nome ou CPF:</label><br>
    <input type="text" id="pesquisar" name="pesquisar" placeholder="Digite o nome ou CPF" oninput="formatarCPF(event)"> <br>
    
    <button type="submit" style="background-color: green; color: white;"
            onclick="document.getElementById('acao').value='pesquisar';">
        Pesquisar
    </button>
</form>

@if (isset($erro))
    <div style="color: red; font-weight: bold; margin-top: 10px;">
        {{ $erro }}
    </div>
@elseif (!is_null($pessoas)) {{-- Só exibe se houve pesquisa --}}
    @if (count($pessoas) > 0)
        <div>
            @foreach ($pessoas as $pessoa)
                <div class="resultado">
                    <h2>{{ $pessoa->nome }}</h2>
                    <p><strong>E-mail:</strong> {{ $pessoa->email }}</p>
                </div>
                <div class="linha-separadora"></div>
            @endforeach
        </div>
    @else
        <p>Nenhuma pessoa encontrada para: {{ request()->input('pesquisar') }}</p>
    @endif
@endif

<a href="{{ route('cadastroPage') }}">Realizar Novo Cadastro</a>

@endsection