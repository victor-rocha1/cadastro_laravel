@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<form method="POST" action="{{ route('home') }}">
    @csrf
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

<script>
    // Função para formatar CPF no campo de pesquisa
    function formatarCPF(event) {
        var cpf = event.target.value;

        // Remove todos os caracteres não numéricos
        cpf = cpf.replace(/\D/g, '');

        // Formata CPF com pontos e traço
        if (cpf.length <= 11) {
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        }

        event.target.value = cpf;
    }
</script>

@endsection