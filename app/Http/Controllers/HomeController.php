<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class HomeController extends Controller
{

    public function index()
    {
        $pessoas = null;
        $erro = null;

        return view('home', compact('pessoas', 'erro'));
    }

    public function cadastro()
    {
        return view('cadastro.pessoa');
    }


    public function pesquisar(Request $request)
    {
        try {
            if ($request->filled('pesquisar')) {
                $pesquisa = trim($request->input('pesquisar'));

                // Testa só esse where simples
                $pessoas = Pessoa::where('nome', 'LIKE', "%$pesquisa%")
                    ->orWhere('cpf', 'LIKE', "%$pesquisa%")
                    ->orderBy('nome')
                    ->get();

                return response()->json($pessoas);
            }

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao realizar a pesquisa: ' . $e->getMessage()
            ], 500);
        }
    }
}
