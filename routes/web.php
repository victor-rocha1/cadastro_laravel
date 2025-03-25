<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], '/', [HomeController::class, 'filtrar'])
    ->name('home');

//  admin
Route::prefix('admin')->group(function () {
    // Rota para listar as pessoas
    Route::match(['get', 'post'], '/', [AdminController::class, 'listar'])
        ->name('admin');

    // Rota para editar uma pessoa
    Route::get('/edit/{id}', [AdminController::class, 'edit'])
        ->name('admin.edit');

    // Rota para atualizar os dados de uma pessoa
    Route::put('/update/{id}', [AdminController::class, 'update'])
        ->name('update');
});

// grupo de rotas para Cadastro
Route::prefix('cadastro')->group(function () {
    // exibir o formulário de cadastro de pessoa
    Route::get('/', [PessoaController::class, 'cadastro'])
        ->name('cadastroPage');

    // processar o envio do formulário de cadastro de pessoa
    Route::post('/', [PessoaController::class, 'cadastro'])
        ->name('cadastroPage');

    //  endereço dentro de Cadastro
    Route::prefix('endereco')->group(function () {
        // Rota GET para exibir o formulário de cadastro de endereço
        Route::get('/', [EnderecoController::class, 'formEndereco'])
            ->name('cadastroEnderecoForm');

        // Rota POST para processar o envio do formulário de cadastro de endereço
        Route::post('/', [EnderecoController::class, 'cadastrarEndereco'])
            ->name('cadastroEndereco');
    });
});
