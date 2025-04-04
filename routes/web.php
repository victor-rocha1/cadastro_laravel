<?php

use App\Http\Controllers\{
    AdminController,
    AuthController,
    EnderecoController,
    HomeController,
    PessoaController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redireciona para a home se estiver autenticado, senão para a tela de login
Route::get('/', fn() => auth()->check() ? redirect()->route('home') : redirect()->route('login'));

// Autenticação
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login'); 
    Route::post('/login', 'login'); 
    Route::post('/logout', 'logout')->name('logout'); 
    Route::get('/registrar', 'create')->name('register'); 
    Route::post('/registrar', 'store')->name('register.store'); 
});


// Rota pública
Route::get('/pesquisa', [HomeController::class, 'filtrar'])->name('pesquisa');

// Grupo protegido por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Cadastro de Pessoas e Endereços
    Route::prefix('cadastro')->group(function () {
        Route::match(['get', 'post'], '/pessoa', [PessoaController::class, 'cadastro'])->name('cadastro.pessoa');

        Route::prefix('endereco')->controller(EnderecoController::class)->group(function () {
            Route::get('/', 'formEndereco')->name('cadastro.endereco.form');
            Route::post('/', 'cadastrarEndereco')->name('cadastro.endereco');
        });
    });

    // Rotas Admin
    Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {
        Route::get('/listar', 'listar')->name('admin.listar');
        Route::get('/edit/{id}', 'edit')->name('admin.edit');
        Route::put('/update/{id}', 'update')->name('admin.update');
        Route::delete('/destroy/{id}', 'destroy')->name('admin.destroy');
        Route::get('/restore', 'restore')->name('admin.restore');
        Route::post('/restore/{id}', 'restore')->name('admin.restore.single');
        Route::delete('/force-delete/{id}', 'forceDelete')->name('admin.forceDelete');
    });
});