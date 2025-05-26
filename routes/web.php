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

// LISTAR pessoas
Route::get('/lista', [AdminController::class, 'listar'])->name('admin.listar');

// EDITAR pessoa (form)
Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');

// ATUALIZAR pessoa (form submit)
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');

// DELETAR pessoa
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
