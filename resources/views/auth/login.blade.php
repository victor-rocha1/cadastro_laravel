@extends('layouts.app')

@section('title', 'Sistema de Cadastro')

@section('header', 'Sistema de Cadastro')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
@endsection