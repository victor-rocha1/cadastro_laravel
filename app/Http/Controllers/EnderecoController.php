<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    // Exibe o formulário de endereço
    public function create($pessoa_id)
    {
        // Verifica se a pessoa existe
        $pessoa = Pessoa::findOrFail($pessoa_id);

        // Retorna a view com os dados da pessoa
        return view('cadastro.endereco', compact('pessoa'));
    }

    // Armazena o endereço e associa à pessoa
    public function store(Request $request, $pessoa_id)
    {
        // Validação dos dados de endereço
        $validatedData = $request->validate([
            'logradouro' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cep' => 'required|string|size:8',
        ]);

        // Criação do endereço e associação à pessoa
        $endereco = new Endereco($validatedData);
        $endereco->id_pessoa = $pessoa_id;
        $endereco->save();

        // Redireciona para uma página de sucesso
        return redirect()->route('cadastro.sucesso');
    }
}