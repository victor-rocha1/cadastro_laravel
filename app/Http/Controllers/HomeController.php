<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Log;

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
                $termoPesquisa = trim($request->input('pesquisar'));

                Log::info('Termo de pesquisa recebido: ' . $termoPesquisa);

                $cpfPesquisaNumeros = preg_replace('/[^0-9]/', '', $termoPesquisa);

                $query = Pessoa::query();

                // pesquisa por nome
                $query->where('nome', 'LIKE', "%{$termoPesquisa}%");

                $query->orWhere('cpf', '=', $termoPesquisa); // busca exata pelo CPF formatado
                $query->orWhere('cpf', 'LIKE', "%{$termoPesquisa}%"); // bussca parcial pelo CPF formatado

                // se o usuário digitou apenas números para o CPF
                if (ctype_digit($cpfPesquisaNumeros) && strlen($cpfPesquisaNumeros) > 0) {
                    // constrói o formato esperado no banco (XXX.XXX.XXX-XX) a partir dos números digitados
                    if (strlen($cpfPesquisaNumeros) == 11) {
                        $cpfFormatadoAPartirDeNumeros = vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($cpfPesquisaNumeros));
                        Log::info('CPF formatado a partir de números para busca: ' . $cpfFormatadoAPartirDeNumeros);
                        $query->orWhere('cpf', '=', $cpfFormatadoAPartirDeNumeros);
                    } else {
                    }
                }

                $pessoas = $query->orderBy('nome')->get();

                Log::info('Pessoas encontradas: ' . $pessoas->count());

                return response()->json($pessoas);
            }

            return response()->json([]);
        } catch (\Exception $e) {
            Log::error('Erro ao realizar a pesquisa no HomeController: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Erro ao realizar a pesquisa.'
            ], 500);
        }
    }
}
