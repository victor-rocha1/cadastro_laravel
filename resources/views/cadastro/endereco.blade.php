@extends('layouts.app')

@section('title', 'Cadastrar Endereço')

@section('header', 'Cadastrar Endereço')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">

        <form method="POST" action="{{ route('cadastro.endereco') }}">
            @csrf

            <input type="hidden" name="id_pessoa" value="{{ $id_pessoa ?? '' }}">

            <div class="mb-3">
                <label for="cep" class="form-label fw-bold">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control" required maxlength="10" placeholder="00000-000" onblur="consultarCEP()">
            </div>

            <div class="mb-3">
                <label for="logradouro" class="form-label  fw-bold">Logradouro:</label>
                <input type="text" name="logradouro" id="logradouro" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="numero" class="form-label fw-bold">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control" required maxlength="4" placeholder="00">
            </div>

            <div class="mb-3">
                <label for="complemento" class="form-label fw-bold">Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="form-control">
            </div>

            <div class="mb-3">
                <label for="bairro" class="form-label fw-bold">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label  fw-bold">Estado:</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Selecione o estado</option>
                    @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $estado)
                    <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label fw-bold">Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>
                <button type="submit" class="btn btn-success">Finalizar Cadastro</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection