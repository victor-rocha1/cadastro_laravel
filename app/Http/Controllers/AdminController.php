<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function listar()
    {
        $pessoas = Pessoa::with('endereco')->orderBy('nome', 'asc')->get();
        return view('admin.listar', [
            'pessoas' => $pessoas,
            'erro' => $pessoas->isEmpty() ? "Nenhuma pessoa cadastrada." : null
        ]);
    }

    // editar
    public function edit($id)
    {
        $dados = Pessoa::with('endereco')->find($id);

        if (!$dados) {
            return redirect()->route('admin.listar')->with('erro', 'Pessoa não encontrada.');
        }

        return view($dados->trashed() ? 'admin.restore' : 'admin.edit', [
            'dados' => $dados,
            'id' => $dados->id
        ]);
    }

    // atualizar
  public function update(Request $request, $id)
{
    try {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:14',
            'email' => 'required|email',
            // Se quiser, pode validar aqui os campos do endereço também
            'cep' => 'nullable|string|max:20',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cidade' => 'nullable|string|max:255',
        ]);

        $pessoa = Pessoa::findOrFail($id);

        $pessoa->update($request->only([
            'nome',
            'nome_social',
            'cpf',
            'nome_pai',
            'nome_mae',
            'telefone',
            'email'
        ]));

        $dadosEndereco = $request->only([
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'estado',
            'cidade'
        ]);

        // Cria ou atualiza o endereço da pessoa
        $pessoa->endereco()->updateOrCreate(
            ['id_pessoa' => $pessoa->id],
            $dadosEndereco
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cadastro atualizado com sucesso.',
                'pessoa' => $pessoa->load('endereco')
            ]);
        }

        return redirect()->route('admin.listar')->with('success', 'Cadastro atualizado com sucesso.');
    } catch (\Exception $e) {

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar cadastro: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()->with('erro', 'Erro ao atualizar cadastro: ' . $e->getMessage());
    }
}



    // deletar
    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->delete();

        return redirect()->route('admin.listar')->with('success', 'Pessoa excluída com sucesso.');
    }

    public function restore($id = null)
    {
        if ($id) {
            Pessoa::onlyTrashed()->findOrFail($id)->restore();
            return redirect()->route('admin.restore')->with('success', 'Pessoa restaurada com sucesso!');
        }

        $pessoas = Pessoa::onlyTrashed()->get();
        return view('admin.restore', [
            'pessoas' => $pessoas,
            'erro' => $pessoas->isEmpty() ? "Nenhuma pessoa excluída." : null
        ]);
    }

    public function forceDelete($id)
    {
        Pessoa::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.restore')->with('success', 'Pessoa excluída permanentemente.');
    }

    public function getPessoa($id)
    {
        $pessoa = Pessoa::with('endereco')->find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa);
    }
}
