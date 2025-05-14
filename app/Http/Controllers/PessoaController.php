<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function cadastro(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'nome_social' => 'nullable|string|max:255',
            'cpf' => 'required|string|size:14',
            'nome_pai' => 'nullable|string|max:255',
            'nome_mae' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'nullable|email',
        ]);

        // Criação da Pessoa
        $pessoa = Pessoa::create($validatedData);

        // Retorne JSON com a URL já montada
        return response()->json([
            'redirect' => route('cadastro.endereco', ['pessoa_id' => $pessoa->id])
        ]);
    }
}
