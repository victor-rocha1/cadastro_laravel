@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')

<form method="POST" action="{{ route('home') }}">
    @csrf
    <label for="pesquisar">Pesquisar por nome ou CPF:</label><br>
    <input type="text" id="pesquisar" name="pesquisar" placeholder="Digite o nome ou CPF" required> <br>
    <button type="submit">Pesquisar</button>
</form>

@if (isset($pessoas) && count($pessoas) > 0)
<div>
    @foreach ($pessoas as $pessoa)
    <div class="resultado">
        <h2><strong></strong> {{ $pessoa['nome'] }}</h2>
        <p><strong>CPF:</strong> {{ $pessoa['cpf'] }}</p>
    </div>
    <div class="linha-separadora"></div>
    @endforeach
</div>

@elseif (isset($pesquisar))
<p>Nenhuma pessoa encontrada para: {{ $pesquisar }}</p>
@endif

<a href="{{ route('cadastroPage') }}">Realizar Novo Cadastro</a>

@endsection