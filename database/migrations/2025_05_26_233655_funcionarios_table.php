<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nome');
            $table->string('cpf', 14)->unique();
            $table->string('matricula', 50)->unique();
            $table->string('cargo')->nullable();
            $table->date('data_admissao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
};
