<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Pessoa extends Model
{
    use HasFactory, SoftDeletes; 

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

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id_pessoa', 'id');
    }
}