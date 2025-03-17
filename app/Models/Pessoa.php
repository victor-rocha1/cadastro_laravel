<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas'; 

    protected $fillable = [
        'nome', 
        'nome_social', 
        'cpf', 
        'nome_pai', 
        'nome_mae', 
        'telefone',
        'email', 
    ];
}
