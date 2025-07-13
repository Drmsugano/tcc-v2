<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
       public function up()
    {
        Schema::create('NOTIFICACOES', function (Blueprint $table) {
            $table->id();
            $table->foreignId('USER_ID')->nullable()->constrained('USUARIOS')->onDelete('cascade');
            $table->string('TITULO');
            $table->text('MENSAGEM');
            $table->enum('TIPO', ['EPI', 'DOCUMENTO', 'SISTEMA', 'GERAL'])->default('GERAL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacoes');
    }
};
