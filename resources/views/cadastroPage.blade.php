@extends('layouts.app')

@extends('layouts.errors')

@section('title', 'Cadastrar Usuário')

@section('header', 'Cadastrar Usuário')

@section('content')
<form method="POST" action="{{ route('cadastroPage') }}">
    @csrf

    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" placeholder="Nome" required><br>

    <label for="nome_social">Nome Social (opcional):</label><br>
    <input type="text" name="nome_social" placeholder="Nome Social"><br>

    <label for="cpf">CPF:</label><br>
    <input type="text" name="cpf" placeholder="000.000.000-00" required><br>

    <label for="nome_pai">Nome do Pai:</label><br>
    <input type="text" name="nome_pai" placeholder="Nome do Pai"><br>

    <label for="nome_mae">Nome da Mãe:</label><br>
    <input type="text" name="nome_mae" placeholder="Nome da Mãe"><br>

    <label for="telefone">Telefone:</label><br>
    <input type="tel" name="telefone" placeholder="(31) 99999-9999"><br>

    <label for="email">E-mail:</label><br>
    <input type="email" name="email" placeholder="pessoa@gmail.com"><br>

    <button type="submit">Próximo</button>
</form>

@include('layouts.errors')
@endsection