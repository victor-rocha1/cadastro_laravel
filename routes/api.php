<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\EnderecoController;
use App\Models\Pessoa;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pesquisar', [HomeController::class, 'pesquisar']);
Route::post('/pessoa', [PessoaController::class, 'cadastro']);
Route::post('/endereco', [EnderecoController::class, 'store']);

Route::get('/pessoa/ultimo-id', function () {
    $ultimoId = Pessoa::max('id');
    return response()->json(['ultimoId' => $ultimoId]);
});

Route::get('/pessoas', [AdminController::class, 'apiListar']);

Route::get('/admin/{id}', [AdminController::class, 'getPessoa']);

Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('api.admin.destroy');

Route::get('/pessoas/trashed', [AdminController::class, 'apiListarTrashed']);
Route::post('/admin/{id}/restore', [AdminController::class, 'restore'])->name('api.admin.restore');
Route::delete('/admin/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('api.admin.forceDelete');