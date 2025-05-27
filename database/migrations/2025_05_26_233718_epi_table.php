<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('epis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('validade')->nullable();
            $table->string('ca');
            $table->integer('quantidade_estoque')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('epis');
    }
};
