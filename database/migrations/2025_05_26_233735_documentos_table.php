<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('DOCUMENTOS', function (Blueprint $table) {
            $table->id();
            $table->foreignId('FUNCIONARIO_ID')->constrained('FUNCIONARIOS')->onDelete('cascade');
            $table->enum('TIPO', ['ASO', 'Treinamento NR', 'Ficha de EPI']);
            $table->text('DESCRICAO')->nullable();
            $table->date('DATA_EMISSAO');
            $table->date('DATA_VALIDADE')->nullable();
            $table->string('ARQUIVO')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
