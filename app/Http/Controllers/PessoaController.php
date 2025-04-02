<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    public function cadastro(Request $request)
    {
        if ($request->isMethod('post')) {
            // Remove caracteres não numéricos do telefone
            $request->merge([
                'telefone' => preg_replace('/\D/', '', $request->telefone)
            ]);

            $dadosPessoa = $request->validate([
                'nome' => 'required|string|max:255',
                'nome_social' => 'nullable|string|max:255',
                'nome_pai' => 'nullable|string|max:255',
                'nome_mae' => 'nullable|string|max:255',
                'cpf' => 'required|string|max:14|unique:pessoas,cpf',
                'email' => 'nullable|email|max:255|unique:pessoas,email',
                'telefone' => 'required|string|max:20|unique:pessoas,telefone',
            ], [
                'nome.required' => 'O campo nome é obrigatório.',
                'cpf.required' => 'O CPF é obrigatório.',
                'cpf.unique' => 'Este CPF já está cadastrado.',
                'email.unique' => 'Este email já está cadastrado.',
                'email.email' => 'Digite um e-mail válido.',
                'telefone.unique' => 'Este telefone já está cadastrado.'
            ]);

            // Salva os dados no banco antes de redirecionar
            $pessoa = Pessoa::create($dadosPessoa);

            // Armazena apenas o ID na sessão
            session(['id_pessoa' => $pessoa->id]);

            return redirect()->route('cadastro.endereco.form');
        }

        return view('cadastro.pessoa');
    }
}