<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listar()
    {
        $pessoas = Pessoa::all();
        $erro = null;

        if ($pessoas->isEmpty()) {
            $erro = "Nenhuma pessoa cadastrada.";
        }

        return view('admin_pessoas', compact('pessoas', 'erro'));
    }

    public function edit($id)
    {
        // Carregar a pessoa com o endereço
        $dados = Pessoa::with('endereco')->find($id);

        if ($dados) {
            return view('edit', compact('dados'));
        } else {
            return redirect()->route('admin')->with('erro', 'Pessoa não encontrada.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validar os dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string',
            'email' => 'required|email',
        ]);

        // Encontrar a pessoa
        $pessoa = Pessoa::find($id);

        if ($pessoa) {
            // Atualizar dados da pessoa
            $pessoa->update([
                'nome' => $request->nome,
                'nome_social' => $request->nome_social ?? '',
                'cpf' => $request->cpf ?? '',
                'nome_pai' => $request->nome_pai ?? '',
                'nome_mae' => $request->nome_mae ?? '',
                'telefone' => $request->telefone ?? '',
                'email' => $request->email,
            ]);

            // Atualizar o endereço 
            if ($pessoa->endereco) {
                $pessoa->endereco->update([
                    'cep' => $request->cep ?? '',
                    'logradouro' => $request->logradouro ?? '',
                    'numero' => $request->numero ?? '',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? '',
                    'estado' => $request->estado ?? '',
                    'cidade' => $request->cidade ?? '',
                ]);
            }

            return redirect()->route('admin')->with('sucesso', 'Cadastro atualizado com sucesso.');
        } else {
            return redirect()->route('admin')->with('erro', 'Pessoa não encontrada.');
        }
    }
}