<?php

use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/pesquisar', [HomeController::class, 'pesquisar']);

Route::post('/cadastro', [PessoaController::class, 'cadastro']);

Route::post('/endereco', [EnderecoController::class, 'cadastrarEndereco']);