<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Route;


Route::get('/pesquisar', [HomeController::class, 'pesquisar']);

Route::post('/pessoa', [PessoaController::class, 'cadastro']);


Route::get('/pessoa/ultimo-id', function () {
    $ultimoId = Pessoa::max('id');  // pega o maior id
    return response()->json(['ultimoId' => $ultimoId]);
});


Route::post('/endereco', [EnderecoController::class, 'store']);

Route::get('/pessoas/{id}', [AdminController::class, 'getPessoa']);