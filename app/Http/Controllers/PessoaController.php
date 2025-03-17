<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    public function cadastro(Request $request) {
        if ($request->isMethod('post')) {
            $dadosPessoa = $request->validate([
                'nome' => 'required|string|max:255',
                'nome_social' => 'nullable|string|max:255',
                'cpf' => 'required|string|max:14|unique:pessoas,cpf',
                'nome_pai' => 'nullable|string|max:255',
                'nome_mae' => 'nullable|string|max:255',
                'telefone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:pessoas,email',
            ]);

            $pessoa = Pessoa::create($dadosPessoa); // Salva no banco de dados com Eloquent

            if ($pessoa) {
                return redirect()->route('cadastroEndereco', ['id_pessoa' => $pessoa->id]);
            } else {
                return back()->withErrors(['Erro ao cadastrar pessoa.']);
            }
        }

        return view('cadastroPessoa');
    }
}