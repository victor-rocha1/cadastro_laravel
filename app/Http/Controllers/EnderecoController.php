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

        return view('enderecoPage', compact('dadosPessoa'));
    }

    public function cadastrarEndereco(Request $request)
    {
        $dadosPessoa = session('dados_pessoa');

        if (!$dadosPessoa) {
            return redirect()->route('cadastroPage')->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        // Lista de estados válidos
        $estadosValidos = [
            "AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO"
        ];

        // Validação do formulário
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

        // remove a formatação do CEP e do número
        $validatedEndereco['cep'] = preg_replace('/\D/', '', $validatedEndereco['cep']); 
        // remove qualquer caractere não numérico
        $validatedEndereco['numero'] = preg_replace('/\D/', '', $validatedEndereco['numero']); 

        try {
            DB::beginTransaction();

            // cria o registro de pessoas
            $pessoa = Pessoa::create($dadosPessoa);

            //atribuindo o id da pessoa no endereço
            $validatedEndereco['id_pessoa'] = $pessoa->id;

            // criação do registro de endereço
            Endereco::create($validatedEndereco);

            DB::commit();

            // limpa todos os dados das variáveis dps de salvar no banco
            session()->forget('dados_pessoa');

            return redirect()->route('home')->with('success', 'Cadastro finalizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar endereço: ' . $e->getMessage());

            return back()->withErrors(['erro' => 'Erro ao cadastrar: ' . $e->getMessage()]);
        }
    }
}