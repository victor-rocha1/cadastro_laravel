<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{
    public function filtrar(Request $request)
    {
        $pessoas = null;
        $erro = null; // Definimos a variável erro

        if ($request->isMethod('post') && $request->filled('pesquisar')) {
            $pesquisa = $request->input('pesquisar');
            $pessoas = Pessoa::where('nome', 'LIKE', "%$pesquisa%")
                ->orWhere('cpf', 'LIKE', "%$pesquisa%")
                ->get();

            if ($pessoas->isEmpty()) {
                $erro = "Nenhuma pessoa encontrada para: $pesquisa"; // Atribuímos o erro sem usar session()
            }
        }

        return view('home', compact('pessoas', 'erro'));
    }
}
