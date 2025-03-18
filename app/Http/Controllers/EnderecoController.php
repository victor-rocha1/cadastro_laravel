<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Endereco;

class EnderecoController extends Controller
{
    // Método GET para exibir o formulário
    public function formEndereco()
    {
        return view('enderecoPage'); 
    }

    // Método POST para processar o envio dos dados
    public function cadastrarEndereco(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'id_pessoa' => 'required|exists:pessoas,id',
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'estado' => 'required|string',
            'cidade' => 'required|string',
        ]);

        // Criar o endereço no banco de dados
        $endereco = Endereco::create($validated);

        // Verificar se o endereço foi criado com sucesso
        if ($endereco) {
            return redirect()->route('home')->with('success', 'Endereço cadastrado com sucesso!');
        } else {
            return back()->withErrors(['erro' => 'Erro ao cadastrar endereço.']);
        }
    }
}