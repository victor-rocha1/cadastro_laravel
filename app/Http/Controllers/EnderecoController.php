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
        $dadosPessoa = session('dados_pessoa', []);

        if (empty($dadosPessoa)) {
            return redirect()->route('cadastroPage')->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        return view('enderecoPage');
    }

    public function cadastrarEndereco(Request $request)
    {
        $dadosPessoa = session('dados_pessoa');

        if (!$dadosPessoa) {
            return redirect()->route('cadastroPage')->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        // Validação do endereço
        $validatedEndereco = $request->validate([
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'estado' => 'required|string|size:2',
            'cidade' => 'required|string',
        ]);

        // Remove a formatação do CEP e número
        $validatedEndereco['cep'] = preg_replace('/\D/', '', $validatedEndereco['cep']);
        $validatedEndereco['numero'] = preg_replace('/\D/', '', $validatedEndereco['numero']);

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::create($dadosPessoa);

            // Associa o endereço ao ID da pessoa criada
            $validatedEndereco['id_pessoa'] = $pessoa->id;

            // criação do endereço no banco
            Endereco::create($validatedEndereco);

            DB::commit();

            // remove os dados da sessão após finalizar
            session()->forget('dados_pessoa');

            return redirect()->route('home')->with('success', 'Cadastro finalizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar endereço: ' . $e->getMessage());

            return back()->withErrors(['erro' => 'Erro ao cadastrar: ' . $e->getMessage()]);
        }
    }
}