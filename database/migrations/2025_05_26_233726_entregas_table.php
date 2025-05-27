<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entregas_epi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->foreignId('epi_id')->constrained('epis')->onDelete('cascade');
            $table->date('data_entrega');
            $table->date('validade')->nullable();
            $table->integer('quantidade')->default(1);
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entregas_epi');
    }
};
