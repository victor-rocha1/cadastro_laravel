@extends('layouts.app')

@section('title', 'Cadastrar Usuário')

@section('header', 'Cadastrar Endereço')

@section('content')

<form method="POST" action="{{ route('cadastroEndereco') }}">
    @csrf

    <input type="hidden" name="id_pessoa" value="{{ $id_pessoa ?? '' }}">

    <label for="cep">CEP:</label><br>
    <input type="text" name="cep" id="cep" required><br>

    <label for="logradouro">Logradouro:</label><br>
    <input type="text" name="logradouro" id="logradouro" required><br>

    <label for="numero">Número:</label><br>
    <input type="text" name="numero" id="numero" required><br>

    <label for="complemento">Complemento:</label><br>
    <input type="text" name="complemento" id="complemento"><br>

    <label for="bairro">Bairro:</label><br>
    <input type="text" name="bairro" id="bairro" required><br>

    <label for="estado">Estado:</label><br>
    <input type="text" name="estado" id="estado" required><br>

    <label for="cidade">Cidade:</label><br>
    <input type="text" name="cidade" id="cidade" required><br>

    <button type="submit">Finalizar Cadastro</button>
</form>

@if ($errors->any())
<div style="color: red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@endsection