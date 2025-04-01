@extends('layouts.app')

@section('title', 'Cadastrar Usuário')

@section('header', 'Cadastrar Usuário')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">

        <form method="POST" action="{{ route('cadastro.pessoa') }}">
            @csrf

            <div class="mb-3">
                <label for="nome" class="form-label fw-bold">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" required>
            </div>

            <div class="mb-3">
                <label for="nome_social" class="form-label fw-bold">Nome Social (opcional):</label>
                <input type="text" class="form-control" name="nome_social" placeholder="Nome Social">
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label fw-bold">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="000.000.000-00" required oninput="formatarCPF(event)" maxlength="14">
            </div>

            <div class="mb-3">
                <label for="nome_pai" class="form-label fw-bold">Nome do Pai:</label>
                <input type="text" class="form-control" name="nome_pai" placeholder="Nome do Pai">
            </div>

            <div class="mb-3">
                <label for="nome_mae" class="form-label fw-bold">Nome da Mãe:</label>
                <input type="text" class="form-control" name="nome_mae" placeholder="Nome da Mãe">
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label fw-bold">Telefone:</label>
                <input type="tel" class="form-control" name="telefone" id="telefone" placeholder="(31) 99999-9999">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail:</label>
                <input type="email" class="form-control" name="email" placeholder="pessoa@gmail.com">
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">Próximo</button>
        </form>
    </div>
</div>
@endsection