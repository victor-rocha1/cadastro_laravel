<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

// Redireciona para a home se estiver autenticado, senão vai para a tela de login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('/home') : redirect()->route('login');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota pública (pesquisa pode ser acessada sem login)
Route::get('/pesquisa', [HomeController::class, 'filtrar'])->name('pesquisa');

// Grupo de rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Página inicial (após login)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Cadastro de Pessoas e Endereços
    Route::prefix('cadastro')->group(function () {
        Route::match(['get', 'post'], '/pessoa', [PessoaController::class, 'cadastro'])->name('cadastro.pessoa');

        Route::prefix('endereco')->group(function () {
            Route::get('/', [EnderecoController::class, 'formEndereco'])->name('cadastro.endereco.form');
            Route::post('/', [EnderecoController::class, 'cadastrarEndereco'])->name('cadastro.endereco');
        });
    });

    // Rotas Administrativas (com middleware de admin)
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/listar', [AdminController::class, 'listar'])->name('admin.listar');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/restore', [AdminController::class, 'restore'])->name('admin.restore');
        Route::post('/restore/{id}', [AdminController::class, 'restore'])->name('admin.restore.single');
        Route::delete('/force-delete/{id}', [AdminController::class, 'forceDelete'])->name('admin.forceDelete');
    });
});
