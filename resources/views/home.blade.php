@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<form method="POST" action="{{ route('home') }}">
    @csrf

    <div class="consulta">
        <input type="submit" value="Listar todos os cadastros">
        <input type="submit" value="Alterar Dados">
    </div>


    <label for="pesquisar">Pesquisar por nome ou CPF:</label><br>
    <input type="text" id="pesquisar" name="pesquisar" placeholder="Digite o nome ou CPF" required oninput="formatarCPF(event)"> <br>
    <button type="submit">Pesquisar</button>
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