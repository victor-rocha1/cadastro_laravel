<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{
    public function filtar(Request $request)
    {
        $pessoas = null;
        $erro = null;  // Variável para armazenar o erro, se houver

        // Só faz a pesquisa se o campo 'pesquisar' for preenchido
        if ($request->isMethod('post') && $request->filled('pesquisar')) {
            $pesquisa = $request->input('pesquisar');

            // busca no banco de dados por nome e cpf
            $pessoas = Pessoa::where('nome', 'LIKE', "%$pesquisa%")
                ->orWhere('email', 'LIKE', "%$pesquisa%")
                ->get();


            // Se não encontrar nenhum resultado, define a mensagem de erro
            if ($pessoas->isEmpty()) {
                $erro = "Nenhuma pessoa encontrada para: $pesquisa";
            }
        }

        return view('home', compact('pessoas', 'erro'));
    }
}
