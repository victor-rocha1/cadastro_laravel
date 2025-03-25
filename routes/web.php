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

// Página inicial
Route::match(['get', 'post'], '/', [HomeController::class, 'filtrar'])
    ->name('home');

// Grupo de rotas para Cadastro de Pessoa e Endereço
Route::prefix('cadastro')->group(function () {
    // Exibir formulário e processar envio de Pessoa
    Route::match(['get', 'post'], '/pessoa', [PessoaController::class, 'cadastro'])
        ->name('cadastro.pessoa');

    // Grupo de rotas para Cadastro de Endereço
    Route::prefix('endereco')->group(function () {
        // Exibir formulário de endereço
        Route::get('/', [EnderecoController::class, 'formEndereco'])
            ->name('cadastro.endereco.form');

        // Processar envio do formulário de endereço
        Route::post('/', [EnderecoController::class, 'cadastrarEndereco'])
            ->name('cadastro.endereco');
    });
});

// Grupo de rotas para Administração
Route::prefix('admin')->group(function () {
    // Rota para listar as pessoas (GET puro)
    Route::get('/listar', [AdminController::class, 'listar'])
        ->name('admin.listar');

    // Rota para editar uma pessoa
    Route::get('/edit/{id}', [AdminController::class, 'edit'])
        ->name('admin.edit');

    // Rota para atualizar os dados de uma pessoa
    Route::put('/update/{id}', [AdminController::class, 'update'])
        ->name('admin.update');

    // Rota para deletar uma pessoa
    Route::delete('/delete/{id}', [AdminController::class, 'delete'])
        ->name('admin.delete');
});