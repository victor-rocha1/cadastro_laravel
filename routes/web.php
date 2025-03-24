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

// Rota de Admin - editar e deletar 
Route::match(['get', 'post'], '/admin', [AdminController::class, 'listar'])
    ->name('admin');

// Rota para exibir o formulário de cadastro de pessoa
Route::get('/cadastro', [PessoaController::class, 'cadastro'])
    ->name('cadastroPage');

// Rota para processar o envio do formulário de cadastro de pessoa
Route::post('/cadastro', [PessoaController::class, 'cadastro'])
    ->name('cadastroPage');

// Rota GET para exibir o formulário de cadastro de endereço
Route::get('/cadastro-endereco', [EnderecoController::class, 'formEndereco'])
    ->name('cadastroEnderecoForm');

// Rota POST para processar o envio do formulário de cadastro de endereço
Route::post('/cadastro-endereco', [EnderecoController::class, 'cadastrarEndereco'])
    ->name('cadastroEndereco');