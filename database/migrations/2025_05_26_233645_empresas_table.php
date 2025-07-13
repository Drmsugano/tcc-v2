<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
    {
        Schema::create('EMPRESAS', function (Blueprint $table) {
            $table->id();
            $table->string('NOME', 100)->unique();
            $table->string('EMAIL', 100)->nullable();
            $table->string('RAZAO_SOCIAL', 100)->nullable();
            $table->string('NOME_FANTASIA', 100)->nullable();
            $table->string('CNPJ', 20)->unique();
            $table->string('ENDERECO')->nullable();
            $table->string('TELEFONE', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
