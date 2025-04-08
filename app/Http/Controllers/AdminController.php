<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listar()
    {
        $pessoas = Pessoa::with('endereco')->get();
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

        return view($dados->trashed() ? 'admin.restore' : 'admin.edit', compact('dados'));
    }

    //atualizar
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:14', // (000.000.000-00)
            'email' => 'required|email',
        ]);

        $pessoa = Pessoa::findOrFail($id);
        $pessoa->update($request->only([
            'nome', 'nome_social', 'cpf', 'nome_pai', 'nome_mae', 'telefone', 'email'
        ]));

        $pessoa->endereco()->updateOrCreate([], $request->only([
            'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'estado', 'cidade'
        ]));

        return redirect()->route('admin.listar')->with('success', 'Cadastro atualizado com sucesso.');
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
}