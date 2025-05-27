<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function listar()
    {
        // Filtra as pessoas para exibir apenas as que NÃO foram logicamente deletadas (deleted_at é nulo).
        $pessoas = Pessoa::with('endereco')
            ->whereNull('deleted_at')
            ->orderBy('nome', 'asc')
            ->get();

        return view('admin.listar', [
            'pessoas' => $pessoas,
            'erro' => $pessoas->isEmpty() ? "Nenhuma pessoa cadastrada." : null
        ]);
    }

    public function apiListar()
    {
        // retorna apenas as pessoas que n forma excluídas non front
        $pessoas = Pessoa::with('endereco')
            ->whereNull('deleted_at')
            ->orderBy('nome', 'asc')
            ->get();
        return response()->json($pessoas);
    }

    public function edit($id)
    {
        $dados = Pessoa::withTrashed()->with('endereco')->find($id);

        if (!$dados) {
            return redirect()->route('admin.listar')->with('erro', 'Pessoa não encontrada.');
        }

        // se a pessoa estiver soft deletada, sugere a view de restauração.
        return view($dados->trashed() ? 'admin.restore' : 'admin.edit', [
            'dados' => $dados,
            'id' => $dados->id
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'nullable|string|size:14',
                'email' => 'required|email',
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

    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);

        // Primeiro, soft delete do endereço relacionado
        if ($pessoa->endereco) {
            $pessoa->endereco->delete();
        }
        $pessoa->delete();

        // mensagem de sucesso para o front
        return response()->json(['success' => true, 'message' => 'Pessoa e endereço excluídos com sucesso (soft delete).']);
    }

    public function restore($id = null)
    {
        if ($id) {
            $pessoa = Pessoa::onlyTrashed()->findOrFail($id);
            $pessoa->restore();

            // Restaura o endereço também se ele foi soft deletado junto
            if ($pessoa->endereco()->onlyTrashed()->exists()) {
                $pessoa->endereco()->onlyTrashed()->restore();
            }
            return redirect()->route('admin.restore')->with('success', 'Pessoa restaurada com sucesso!');
        }

        // lista todas as pessoas que estão soft deletadas
        $pessoas = Pessoa::onlyTrashed()->get();
        return view('admin.restore', [
            'pessoas' => $pessoas,
            'erro' => $pessoas->isEmpty() ? "Nenhuma pessoa excluída." : null
        ]);
    }

    public function forceDelete($id)
    {
        $pessoa = Pessoa::onlyTrashed()->findOrFail($id);
        // exclui permanentemente o endereço associado primeiro
        if ($pessoa->endereco()->onlyTrashed()->exists()) {
            $pessoa->endereco()->onlyTrashed()->forceDelete();
        }
        $pessoa->forceDelete();
        return redirect()->route('admin.restore')->with('success', 'Pessoa excluída permanentemente.');
    }

    public function getPessoa($id)
    {
        $pessoa = Pessoa::withTrashed()->with('endereco')->find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa);
    }
}