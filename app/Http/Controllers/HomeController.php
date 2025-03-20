<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{
    public function filtrar(Request $request)
    {
        $pessoas = null;

        if ($request->isMethod('post') && $request->filled('pesquisar')) {
            $pesquisa = $request->input('pesquisar');
            $pessoas = Pessoa::where('nome', 'LIKE', "%$pesquisa%")
                ->orWhere('cpf', 'LIKE', "%$pesquisa%")
                ->get();

            if ($pessoas->isEmpty()) {
                session()->flash('erro', "Nenhuma pessoa encontrada para: $pesquisa");
            }
        }

        return view('home', compact('pessoas'));
    }
}