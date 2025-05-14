<?php

use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;

use Illuminate\Support\Facades\Route;


Route::get('/pesquisar', [HomeController::class, 'pesquisar']);

Route::post('/pessoa', [PessoaController::class, 'cadastro']);

Route::post('/endereco', [EnderecoController::class, 'cadastrarEndereco']);