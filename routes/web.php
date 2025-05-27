<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PessoaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/pessoa', function () {
    return view('cadastro.pessoa');
});

Route::post('/pessoa', [PessoaController::class, 'cadastro']);

Route::get('/endereco', function () {
    return view('cadastro.endereco');
})->name('cadastro.endereco');

// Rota para a view de listagem. Essa view usará um componente Vue para carregar os dados.
Route::get('/lista', [AdminController::class, 'listar'])->name('admin.listar');

// EDITAR pessoa (form) - Mostra o formulário de edição de uma pessoa específica
Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');

// ATUALIZAR pessoa (form submit) - Processa a atualização de uma pessoa
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');

// Rotas para a lixeira/restauração de cadastros (views)
Route::get('/admin/restore/{id?}', [AdminController::class, 'restore'])->name('admin.restore');