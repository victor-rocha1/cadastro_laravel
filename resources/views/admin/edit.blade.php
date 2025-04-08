@extends('layouts.app')

@section('title', 'Editar Cadastro')

@section('header', 'Editar Cadastro')

@section('content')
@if (session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('admin.update', $dados->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Formulário de Cadastro de Pessoa -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ old('nome', $dados->nome) }}" required>
            </div>

            <div class="mb-3">
                <label for="nome_social" class="form-label">Nome Social (opcional):</label>
                <input type="text" class="form-control" name="nome_social" placeholder="Nome Social" value="{{ old('nome_social', $dados->nome_social) }}">
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="000.000.000-00" value="{{ old('cpf', $dados->cpf) }}" required oninput="formatarCPF(event)" maxlength="14">
            </div>

            <div class="mb-3">
                <label for="nome_pai" class="form-label">Nome do Pai:</label>
                <input type="text" class="form-control" name="nome_pai" placeholder="Nome do Pai" value="{{ old('nome_pai', $dados->nome_pai) }}">
            </div>

            <div class="mb-3">
                <label for="nome_mae" class="form-label">Nome da Mãe:</label>
                <input type="text" class="form-control" name="nome_mae" placeholder="Nome da Mãe" value="{{ old('nome_mae', $dados->nome_mae) }}">
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="tel" class="form-control" name="telefone" placeholder="(31) 99999-9999" value="{{ old('telefone', $dados->telefone) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" name="email" placeholder="pessoa@gmail.com" value="{{ old('email', $dados->email) }}">
            </div>
        </div>

        <!-- Formulário de Endereço (caso haja relação) -->
        <div class="col-md-6">
            @if(isset($dados->endereco))
            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control" value="{{ old('cep', $dados->endereco->cep) }}" required maxlength="10" placeholder="00000-000" onblur="consultarCEP()">
            </div>

            <div class="mb-3">
                <label for="logradouro" class="form-label">Logradouro:</label>
                <input type="text" name="logradouro" id="logradouro" class="form-control" value="{{ old('logradouro', $dados->endereco->logradouro) }}" required>
            </div>

            <div class="mb-3">
                <label for="numero" class="form-label">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero', $dados->endereco->numero) }}" required maxlength="4" placeholder="00" oninput="somenteNumeros(event)">
            </div>

            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="form-control" value="{{ old('complemento', $dados->endereco->complemento) }}">
            </div>

            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="{{ old('bairro', $dados->endereco->bairro) }}" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Selecione o estado</option>
                    @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $estado)
                    <option value="{{ $estado }}" {{ $dados->endereco->estado == $estado ? 'selected' : (old('estado') == $estado ? 'selected' : '') }}>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $dados->endereco->cidade) }}" required>
            </div>
            @endif
        </div>
    </div>

    <button type="submit" class="mb-3 btn btn-success w-100">Salvar Dados</button>
</form>

@endsection