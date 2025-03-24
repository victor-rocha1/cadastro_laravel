<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{
    public function filtrar(Request $request)
    {
        $pessoas = null;
        $erro = null;

        // verifica qual ação foi acionada
        $acao = $request->input('acao');

        if ($acao === 'listar') {
            return redirect()->route('admin');

        } elseif ($acao === 'pesquisar' && $request->filled('pesquisar')) {
            // Filtrar por nome ou CPF
            $pesquisa = $request->input('pesquisar');
            $pessoas = Pessoa::where('nome', 'LIKE', "%$pesquisa%")
                ->orWhere('cpf', 'LIKE', "%$pesquisa%")
                ->get();

            if ($pessoas->isEmpty()) {
                $erro = "Nenhuma pessoa encontrada para: $pesquisa";
            }
        }

        return view('home', compact('pessoas', 'erro'));
    }
}