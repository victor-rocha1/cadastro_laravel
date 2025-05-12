<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/pessoa', function () {
    return view('cadastro.pessoa');
});