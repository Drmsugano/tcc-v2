<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
       public function up()
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('usuarios')->onDelete('cascade');
            $table->string('titulo');
            $table->text('mensagem');
            $table->enum('tipo', ['EPI', 'Documento', 'Sistema']);
            $table->boolean('lida')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacoes');
    }
};
