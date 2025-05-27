<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->enum('tipo', ['ASO', 'Treinamento NR', 'Ficha de EPI']);
            $table->text('descricao')->nullable();
            $table->date('data_emissao');
            $table->date('data_validade')->nullable();
            $table->string('arquivo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
