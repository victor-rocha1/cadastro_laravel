<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EnderecoController; 
use Illuminate\Support\Facades\Route;

// autenticação 
Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/register', [AuthController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->name('register.store')->middleware('guest');

// Rotas para usuários autenticados 
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home'); 

    Route::get('/pessoa', function () {
        return view('cadastro.pessoa');
    })->name('cadastro.pessoa'); 

    Route::post('/pessoa', [PessoaController::class, 'cadastro']);

    Route::get('/endereco', function () {
        return view('cadastro.endereco');
    })->name('cadastro.endereco');
});

// rotas para admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/lista', [AdminController::class, 'listar'])->name('admin.listar');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update'); // Atualiza pessoa
    Route::get('/admin/restore/{id?}', [AdminController::class, 'restore'])->name('admin.restore'); // View e lógica de restauração
});
