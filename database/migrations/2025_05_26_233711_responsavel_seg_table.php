<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::create('RESPONSAVEIS_SEGURANCA', function (Blueprint $table) {
            $table->id();
            $table->foreignId('EMPRESA_ID')->constrained('EMPRESAS')->onDelete('cascade');
            $table->string('NOME');
            $table->string('CPF', 14)->unique();
            $table->string('FORMACAO');
            $table->string('NUMERO_REGISTRO_PROFISSIONAL');
            $table->string('TELEFONE')->nullable();
            $table->string('EMAIL')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsaveis_seguranca');
    }
};
