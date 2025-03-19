<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos'; 

    protected $fillable = [
        'id_pessoa', 
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'estado',
        'cidade',
    ];
}