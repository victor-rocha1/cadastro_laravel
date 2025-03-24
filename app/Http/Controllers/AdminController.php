<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listar()
    {
        $pessoas = Pessoa::all();
        $erro = null;

        if ($pessoas->isEmpty()) {
            $erro = "Nenhuma pessoa cadastrada.";
        }

        return view('admin_pessoas', compact('pessoas', 'erro'));
    }
}
