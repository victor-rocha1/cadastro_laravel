<?php

use App\Http\Controllers\AuthController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\EnderecoController;
use App\Models\Pessoa;

// Rotas de API para autenticação
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']); // << ROTA DE LOGOUT API
    
    // Suas rotas de API que exigem autenticação
    Route::post('/pessoa', [PessoaController::class, 'cadastro']);
    Route::post('/endereco', [EnderecoController::class, 'store']);
    Route::get('/pessoa/ultimo-id', function () {
        $ultimoId = Pessoa::max('id');
        return response()->json(['ultimoId' => $ultimoId]);
    });
});

// Rotas de API para Administradores
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/pessoas', [AdminController::class, 'apiListar']);
    Route::get('/admin/{id}', [AdminController::class, 'getPessoa']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('api.admin.destroy');
    Route::get('/pessoas/trashed', [AdminController::class, 'apiListarTrashed']);
    Route::post('/admin/{id}/restore', [AdminController::class, 'restore'])->name('api.admin.restore');
    Route::delete('/admin/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('api.admin.forceDelete');
});

// Rotas de API públicas
Route::get('/pesquisar', [HomeController::class, 'pesquisar']);