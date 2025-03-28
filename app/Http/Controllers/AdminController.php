<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use PDO;

class AdminController extends Controller
{
    public function listar()
    {
        $pessoas = Pessoa::with('endereco')->get();
        $erro = $pessoas->isEmpty() ? "Nenhuma pessoa cadastrada." : null;

        return view('admin.listar', compact('pessoas', 'erro'));
    }

    public function edit($id)
    {
        $dados = Pessoa::with('endereco')->find($id);

        if ($dados) {
            // Se a pessoa estiver apagada, redireciona para a view de restauração
            if ($dados->trashed()) {
                return view('admin.restore', compact('dados'));
            }

            return view('admin.edit', compact('dados'));
        }

        return redirect()->route('admin.listar')->with('erro', 'Pessoa não encontrada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string',
            'email' => 'required|email',
        ]);

        $pessoa = Pessoa::find($id);

        if ($pessoa) {
            $pessoa->update($request->only(['nome', 'nome_social', 'cpf', 'nome_pai', 'nome_mae', 'telefone', 'email']));

            // se a pessoa tiver um endereço, atualiza; se não, cria um novo
            if ($pessoa->endereco) {
                $pessoa->endereco->update($request->only(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'estado', 'cidade']));
            } else {
                $pessoa->endereco()->create($request->only(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'estado', 'cidade']));
            }

            return redirect()->route('admin.listar')->with('sucesso', 'Cadastro atualizado com sucesso.');
        }

        return redirect()->route('admin')->with('erro', 'Pessoa não encontrada.');
    }

    public function destroy($id)
    {
        // Busca a pessoa no banco
        $pessoa = Pessoa::find($id);

        // Exclui a pessoa
        $pessoa->delete();

        return redirect()->route('admin.listar')->with('sucesso', 'Pessoa excluída com sucesso.');
    }

    // Método para listar e restaurar uma pessoa apagada
    public function restore(Request $request, $id = null)
    {
        // Se o ID foi fornecido, restaurar a pessoa específica
        if ($id) {
            $pessoa = Pessoa::onlyTrashed()->findOrFail($id);
            $pessoa->restore();

            return redirect()->route('admin.restore')->with('success', 'Pessoa restaurada com sucesso!');
        }

        // Se não houver ID, listar todas as pessoas excluídas
        $pessoas = Pessoa::onlyTrashed()->get();
        $erro = $pessoas->isEmpty() ? "Nenhuma pessoa excluída." : null;

        return view('admin.restore', compact('pessoas', 'erro'));
    }

    public function forceDelete($id)
    {
        $pessoa = Pessoa::onlyTrashed()->findOrFail($id); // busca apenas registros excluídos
        $pessoa->forceDelete(); // exclui permanentemente

        return redirect()->route('admin.restore')->with('success', 'Pessoa excluída permanentemente.');
    }
}
