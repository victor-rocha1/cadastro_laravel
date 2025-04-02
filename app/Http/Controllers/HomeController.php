<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{
    public function filtrar(Request $request){
        $pessoas = null;
        $erro = null;

        if ($request->filled('pesquisar')) {
            $pesquisa = trim($request->input('pesquisar'));

            $pessoas = Pessoa::whereRaw("LOWER(nome) LIKE ?", ["%" . strtolower($pesquisa) . "%"])
            ->orWhere('cpf', 'LIKE', "%$pesquisa%")
                ->orderBy('nome') // ordena os nomes em ordem alfabética
                ->get();
                
            // dd($pessoas);

            if ($pessoas->isEmpty()) {
                $erro = "Nenhuma pessoa encontrada para: $pesquisa";
            }
        }

        return view('home', compact('pessoas', 'erro'));
    }
}
