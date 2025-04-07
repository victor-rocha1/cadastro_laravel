<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enderecos', function (Blueprint $table) {
            $table->string('cep', 9)->change(); // Alterando de 8 para 9 caracteres
        });
    }

    public function down(): void
    {
        Schema::table('enderecos', function (Blueprint $table) {
            $table->string('cep', 8)->change(); 
        });
    }
};

