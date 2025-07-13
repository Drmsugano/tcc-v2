<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('FUNCIONARIOS', function (Blueprint $table) {
            $table->id();
            $table->foreignId('EMPRESA_ID')->constrained('EMPRESAS')->onDelete('cascade');
            $table->string('NOME');
            $table->string('CPF', 14)->unique();
            $table->string('MATRICULA', 50)->unique();
            $table->string('CARGO')->nullable();
            $table->date('DATA_ADMISSAO');
            $table->date('DATA_DEMISSAO')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
};
