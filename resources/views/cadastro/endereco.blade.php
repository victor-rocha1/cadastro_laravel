@extends('layouts.app')

@section('title', 'Cadastrar Endereço')

@section('header', 'Cadastrar Endereço')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <form method="POST" action="{{ route('cadastro.endereco') }}">
                @csrf

                <input type="hidden" name="id_pessoa" value="{{ $id_pessoa ?? '' }}">

                <div class="mb-3">
                    <label for="cep" class="form-label">CEP:</label>
                    <input type="text" name="cep" id="cep" class="form-control" required maxlength="10" placeholder="00000-000" onblur="consultarCEP()">
                </div>

                <div class="mb-3">
                    <label for="logradouro" class="form-label">Logradouro:</label>
                    <input type="text" name="logradouro" id="logradouro" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control" required maxlength="4" placeholder="00">
                </div>

                <div class="mb-3">
                    <label for="complemento" class="form-label">Complemento:</label>
                    <input type="text" name="complemento" id="complemento" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="bairro" class="form-label">Bairro:</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado:</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="">Selecione o estado</option>
                        @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $estado)
                        <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" required>
                </div>

                <button type="submit" class="mb-3 btn btn-success w-100">Finalizar Cadastro</button>
            </form>

            @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection