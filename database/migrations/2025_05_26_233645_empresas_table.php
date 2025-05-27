<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->string('email', 100)->nullable();
            $table->string('razao_social', 100)->nullable();
            $table->string('nome_fantasia', 100)->nullable();
            $table->string('cnpj', 20)->unique();
            $table->string('endereco')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
