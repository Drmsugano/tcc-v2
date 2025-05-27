<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::create('responsaveis_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nome');
            $table->string('cpf', 14)->unique();
            $table->string('formacao');
            $table->string('numero_registro_profissional');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsaveis_seguranca');
    }
};
