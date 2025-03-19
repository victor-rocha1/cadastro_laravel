<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB; // Adicionado para corrigir o erro
use Illuminate\Support\Facades\Log; // Adicionando Log para capturar erros

class EnderecoController extends Controller
{
    public function formEndereco()
    {
        $dadosPessoa = session('dados_pessoa', []);

        if (empty($dadosPessoa)) {
            return redirect()->route('cadastroPage')->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        return view('enderecoPage', compact('dadosPessoa'));
    }

    public function cadastrarEndereco(Request $request)
    {
        $dadosPessoa = session('dados_pessoa');

        if (!$dadosPessoa) {
            return redirect()->route('cadastroPage')->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        // lista de estados válidos
        $estadosValidos = [
            "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO",  "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"
        ];

        $validatedEndereco = $request->validate([
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'estado' => ['required', 'string', function ($attribute, $value, $fail) use ($estadosValidos) {
                if (!in_array($value, $estadosValidos)) {
                    $fail("O estado selecionado é inválido.");
                }
            }],
            'cidade' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::create($dadosPessoa);
            $validatedEndereco['id_pessoa'] = $pessoa->id;
            Endereco::create($validatedEndereco);

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