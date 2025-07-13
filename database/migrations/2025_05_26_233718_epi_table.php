<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('EPI', function (Blueprint $table) {
            $table->id();
            $table->string('NOME');
            $table->text('DESCRICAO')->nullable();
            $table->integer('VALIDADE')->nullable();
            $table->string('CAT');
            $table->integer('QUANTIDADE_ESTOQUE')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('epis');
    }
};
