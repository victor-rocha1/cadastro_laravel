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
        $idPessoa = session('id_pessoa');

        if (!$idPessoa) {
            return redirect()->route('cadastro.pessoa.form')
                ->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        return view('cadastro.endereco', compact('idPessoa'));
    }

    public function cadastrarEndereco(Request $request)
    {
        $idPessoa = session('id_pessoa');

        if (!$idPessoa) {
            return redirect()->route('cadastro.endereco.form')
                ->withErrors(['erro' => 'Por favor, preencha os dados pessoais primeiro.']);
        }

        // Validação do formulário
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

            // Encontrar a pessoa pelo ID salvo na sessão
            $pessoa = Pessoa::findOrFail($idPessoa);
            $pessoa->endereco()->create($validatedEndereco);

            DB::commit();

            session()->forget('id_pessoa');

            return redirect()->route('home')->with('success', 'Cadastro finalizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar endereço: ' . $e->getMessage());

            return back()->withErrors(['erro' => 'Erro ao cadastrar: ' . $e->getMessage()]);
        }
    }
}
