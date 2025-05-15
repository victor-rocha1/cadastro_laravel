<?php

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
