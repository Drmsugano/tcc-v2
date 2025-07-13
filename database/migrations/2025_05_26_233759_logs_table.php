<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('LOGS', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('USUARIOS')->nullOnDelete();
            $table->string('acao');
            $table->string('tabela_afetada')->nullable();
            $table->integer('registro_id')->nullable();
            $table->text('detalhes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
