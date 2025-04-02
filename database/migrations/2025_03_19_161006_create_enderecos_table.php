<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pessoa')->constrained('pessoas')->onDelete('cascade');
            $table->string('cep', 8);
            $table->string('logradouro', 255);
            $table->string('numero', 20);
            $table->string('complemento', 255)->nullable();
            $table->string('bairro', 255);
            $table->string('estado', 2);
            $table->string('cidade', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
};