<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnderecoController extends Controller
{
    public function formEndereco()
    {
        $dadosPessoa = session('dados_pessoa');

        if (!$dadosPessoa) {
            return redirect()->route('cadastro.pessoa')
                ->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        return view('cadastro.endereco');
    }

    public function cadastrarEndereco(Request $request)
    {
        $dadosPessoa = session('dados_pessoa');

        if (!$dadosPessoa) {
            return redirect()->route('cadastro.pessoa')
                ->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        $validatedEndereco = $request->validate([
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:255',
        ], [
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.max' => 'O CEP deve ter no máximo 9 caracteres.',
            'logradouro.required' => 'O campo logradouro é obrigatório.',
            'numero.required' => 'O número é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.max' => 'O estado deve ter 2 letras (exemplo: SP).',
            'cidade.required' => 'A cidade é obrigatória.',
        ]);

        try {
            DB::beginTransaction();

            // Cria a pessoa
            $pessoa = Pessoa::create($dadosPessoa);

            // Cria o endereço relacionado
            $pessoa->endereco()->create($validatedEndereco);

            DB::commit();

            session()->forget('dados_pessoa');

            return redirect()->route('home')->with('success', 'Cadastro finalizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar endereço: ' . $e->getMessage());

            return back()->withErrors(['erro' => 'Erro ao cadastrar: ' . $e->getMessage()]);
        }
    }
}
