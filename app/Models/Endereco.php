<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importe o trait

class Endereco extends Model
{
    use HasFactory, SoftDeletes; // Use o trait SoftDeletes aqui também!

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

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }
}