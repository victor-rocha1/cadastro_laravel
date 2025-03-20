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

@if (isset($erro))
<script>
    alert("{{ $erro }}"); //para exibe o alerta com a mensagem de erro
</script>
@endif

@if (!is_null($pessoas)) {{-- Só exibe se houve pesquisa --}}
@if (count($pessoas) > 0)
<div>
    @foreach ($pessoas as $pessoa)
    <div class="resultado">
        <h2>{{ $pessoa->nome }}</h2>
        <p><strong>Email:</strong> {{ $pessoa->email }}</p>
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