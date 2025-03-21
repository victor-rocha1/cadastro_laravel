@extends('layouts.app')

@section('title', 'Cadastrar Usuário')

@section('header', 'Cadastrar Endereço')

@section('content')

<form method="POST" action="{{ route('cadastroEndereco') }}">
    @csrf

    <input type="hidden" name="id_pessoa" value="{{ $id_pessoa ?? '' }}">

    <label for="cep">CEP:</label><br>
    <input type="text" name="cep" id="cep" required maxlength="10" placeholder="00000-000"><br>

    <label for="logradouro">Logradouro:</label><br>
    <input type="text" name="logradouro" id="logradouro" required><br>

    <label for="numero">Número:</label><br>
    <input type="text" name="numero" id="numero" required maxlength="15" placeholder="(00) 00000-0000"><br>

    <label for="complemento">Complemento:</label><br>
    <input type="text" name="complemento" id="complemento"><br>

    <label for="bairro">Bairro:</label><br>
    <input type="text" name="bairro" id="bairro" required><br>

    <label for="bairro">Estado:</label><br>
    <select name="estado" id="estado" required>
        <option value="">Selecione um estado</option>
        <option value="AC">Acre</option>
        <option value="AL">Alagoas</option>
        <option value="AP">Amapá</option>
        <option value="AM">Amazonas</option>
        <option value="BA">Bahia</option>
        <option value="CE">Ceará</option>
        <option value="DF">Distrito Federal</option>
        <option value="ES">Espírito Santo</option>
        <option value="GO">Goiás</option>
        <option value="MA">Maranhão</option>
        <option value="MT">Mato Grosso</option>
        <option value="MS">Mato Grosso do Sul</option>
        <option value="MG">Minas Gerais</option>
        <option value="PA">Pará</option>
        <option value="PB">Paraíba</option>
        <option value="PR">Paraná</option>
        <option value="PE">Pernambuco</option>
        <option value="PI">Piauí</option>
        <option value="RJ">Rio de Janeiro</option>
        <option value="RN">Rio Grande do Norte</option>
        <option value="RS">Rio Grande do Sul</option>
        <option value="RO">Rondônia</option>
        <option value="RR">Roraima</option>
        <option value="SC">Santa Catarina</option>
        <option value="SP">São Paulo</option>
        <option value="SE">Sergipe</option>
        <option value="TO">Tocantins</option>
    </select><br>

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

@section('scripts')
@endsection