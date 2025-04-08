@extends('layouts.app')

@section('title', 'Cadastrar Usuário')

@section('title-header', 'Cadastrar Usuário')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">

        <form method="POST" action="{{ route('cadastro.pessoa') }}">
            @csrf

            <div class="mb-3">
                <label for="nome" class="form-label fw-bold">Nome:</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" placeholder="Nome" value="{{ old('nome') }}" required>
                @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nome_social" class="form-label fw-bold">Nome Social (opcional):</label>
                <input type="text" class="form-control" name="nome_social" placeholder="Nome Social" value="{{ old('nome_social') }}">
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label fw-bold">CPF:</label>
                <input type="text" class="form-control"
                    name="cpf" id="cpf" placeholder="000.000.000-00"
                    value="{{ old('cpf') }}" required
                    oninput="formatarCPF(event)"  maxlength="14">

                <div id="erro-cpf" class="invalid-feedback" style="display: none;">
                    CPF inválido. Verifique e tente novamente.
                </div>
            </div>


            <div class="mb-3">
                <label for="nome_pai" class="form-label fw-bold">Nome do Pai:</label>
                <input type="text" class="form-control" name="nome_pai" placeholder="Nome do Pai" value="{{ old('nome_pai') }}">
            </div>

            <div class="mb-3">
                <label for="nome_mae" class="form-label fw-bold">Nome da Mãe:</label>
                <input type="text" class="form-control" name="nome_mae" placeholder="Nome da Mãe" value="{{ old('nome_mae') }}">
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label fw-bold">Telefone:</label>
                <input type="tel" class="form-control @error('telefone') is-invalid @enderror"
                    name="telefone" id="telefone" placeholder="(31) 99999-9999"
                    value="{{ old('telefone') }}">
                @error('telefone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" placeholder="pessoa@gmail.com"
                    value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Botões Voltar e Próximo -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>
                <button type="submit" class="btn btn-success">Próximo</button>
            </div>
        </form>

    </div>
</div>
@endsection