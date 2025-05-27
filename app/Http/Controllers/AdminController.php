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
        // retorna apenas as pessoas que não foram excluídas (soft deleted)
        $pessoas = Pessoa::with('endereco')
            ->whereNull('deleted_at')
            ->orderBy('nome', 'asc')
            ->get();
        return response()->json($pessoas);
    }

    public function apiListarTrashed()
    {
        try {
            $pessoas = Pessoa::onlyTrashed() // Busca apenas registros com soft delete
                           ->with('endereco')
                           ->orderBy('deleted_at', 'desc')
                           ->get();
            return response()->json($pessoas);
        } catch (\Exception $e) {
            Log::error("[AdminController][apiListarTrashed] Erro ao carregar pessoas excluídas via API: " . $e->getMessage());
            return response()->json(['message' => 'Erro ao carregar dados de pessoas excluídas.', 'error' => $e->getMessage()], 500);
        }
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

            // Usar withTrashed() para permitir atualização de pessoas na lixeira, se necessário
            $pessoa = Pessoa::withTrashed()->findOrFail($id);

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

            // Se a pessoa foi restaurada E atualizada, o endereço pode precisar ser restaurado antes de updateOrCreate
            if ($pessoa->trashed() && $pessoa->endereco()->onlyTrashed()->exists()) {
                 $pessoa->endereco()->onlyTrashed()->restore();
            }

            $pessoa->endereco()->updateOrCreate(
                ['id_pessoa' => $pessoa->id],
                $dadosEndereco
            );
            
            // Se a pessoa estava na lixeira e foi atualizada, ela deve ser restaurada
            if ($pessoa->trashed()) {
                $pessoa->restore();
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cadastro atualizado com sucesso.',
                    'pessoa' => $pessoa->load('endereco')
                ]);
            }

            return redirect()->route('admin.listar')->with('success', 'Cadastro atualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error("[AdminController][update] Erro ao atualizar cadastro para Pessoa ID {$id}: " . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar cadastro: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('erro', 'Erro ao atualizar cadastro: ' . $e->getMessage());
        }
    }

    public function destroy($id) // Soft Delete
    {
        try {
            $pessoa = Pessoa::findOrFail($id);

            // Soft delete do endereço relacionado primeiro, se existir
            if ($pessoa->endereco) {
                $pessoa->endereco->delete(); // Soft delete se o modelo Endereco usar SoftDeletes
            }
            $pessoa->delete(); // Soft delete da pessoa

            return response()->json(['success' => true, 'message' => 'Pessoa e endereço (se existente) movidos para a lixeira (soft delete).']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pessoa não encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error("[AdminController][destroy] Erro ao mover para lixeira Pessoa ID {$id}: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao mover para a lixeira: ' . $e->getMessage()], 500);
        }
    }

    public function restore(Request $request, $id = null)
    {
        // Se um ID é fornecido, é uma chamada para restaurar um item específico (provavelmente da API)
        if ($id) {
            Log::info("[AdminController][restore] Tentando restaurar Pessoa ID: {$id}");
            try {
                $pessoa = Pessoa::onlyTrashed()->findOrFail($id);
                $pessoa->restore();
                Log::info("[AdminController][restore] Pessoa ID: {$id} restaurada.");

                // Restaura o endereço também se ele foi soft deletado junto
                if ($pessoa->endereco()->onlyTrashed()->exists()) {
                    $pessoa->endereco()->onlyTrashed()->restore();
                    Log::info("[AdminController][restore] Endereço da Pessoa ID: {$id} restaurado.");
                }
                
                // Para chamadas de API (Vue.js)
                if ($request->wantsJson() || $request->is('api/*')) {
                     return response()->json(['success' => true, 'message' => 'Pessoa restaurada com sucesso!', 'pessoa' => $pessoa->load('endereco')]);
                }
                // Para chamadas web tradicionais
                return redirect()->route('admin.restore')->with('success', 'Pessoa restaurada com sucesso!');

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::warning("[AdminController][restore] Pessoa ID: {$id} não encontrada na lixeira. Erro: " . $e->getMessage());
                 if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json(['success' => false, 'message' => 'Pessoa não encontrada na lixeira.'], 404);
                }
                return redirect()->route('admin.restore')->with('erro', 'Pessoa não encontrada na lixeira.');
            } catch (\Exception $e) {
                Log::error("[AdminController][restore] Erro ao restaurar Pessoa ID: {$id}. Erro: " . $e->getMessage());
                 if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json(['success' => false, 'message' => 'Erro ao restaurar pessoa: ' . $e->getMessage()], 500);
                }
                return redirect()->route('admin.restore')->with('erro', 'Erro ao restaurar pessoa.');
            }
        }

        // Se nenhum ID é fornecido, lista todas as pessoas que estão soft deletadas para a view blade
        $pessoas = Pessoa::onlyTrashed()->with('endereco')->get();
        return view('admin.restore', [
            'pessoas' => $pessoas,
            'erro' => $pessoas->isEmpty() ? "Nenhuma pessoa na lixeira." : null,
            // Passa a mensagem de sucesso da sessão para a view, se houver (após um redirect de restauração web)
            'successMessage' => session('success') 
        ]);
    }

    public function forceDelete(Request $request, $id)
    {
        Log::info("[AdminController][forceDelete] Tentando exclusão permanente para Pessoa ID: {$id}");
        try {
            $pessoa = Pessoa::onlyTrashed()->findOrFail($id);
            Log::info("[AdminController][forceDelete] Pessoa ID: {$id} encontrada na lixeira.");

            $enderecoRelacionado = $pessoa->endereco;
            if ($enderecoRelacionado) {
                Log::info("[AdminController][forceDelete] Endereço ID: {$enderecoRelacionado->id} associado à Pessoa ID: {$id} encontrado. Tentando exclusão permanente do endereço.");
                $enderecoRelacionado->forceDelete();
                Log::info("[AdminController][forceDelete] Endereço ID: {$enderecoRelacionado->id} excluído permanentemente.");
            } else {
                Log::info("[AdminController][forceDelete] Pessoa ID: {$id} não possui endereço associado ou já foi removido.");
            }

            Log::info("[AdminController][forceDelete] Tentando exclusão permanente da Pessoa ID: {$id}.");
            $pessoa->forceDelete();
            Log::info("[AdminController][forceDelete] Pessoa ID: {$id} excluída permanentemente com sucesso.");

            // Para chamadas de API (Vue.js)
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => true, 'message' => 'Pessoa e endereço associado (se existente) excluídos permanentemente.']);
            }
            // Para chamadas web tradicionais (se houver)
            return redirect()->route('admin.restore')->with('success', 'Pessoa excluída permanentemente.');


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("[AdminController][forceDelete] Pessoa ID: {$id} não encontrada na lixeira. Erro: " . $e->getMessage());
             if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Pessoa não encontrada na lixeira.'], 404);
            }
            return redirect()->route('admin.restore')->with('erro', 'Pessoa não encontrada na lixeira para exclusão.');
        } catch (\Exception $e) {
            Log::error("[AdminController][forceDelete] Erro ao excluir permanentemente Pessoa ID: {$id}. Erro: " . $e->getMessage(), ['exception' => $e]);
             if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Erro ao excluir permanentemente a pessoa: ' . $e->getMessage()], 500);
            }
            return redirect()->route('admin.restore')->with('erro', 'Erro ao excluir permanentemente a pessoa.');
        }
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