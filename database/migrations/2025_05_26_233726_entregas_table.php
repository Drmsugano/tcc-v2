<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ENTREGAS_EPI', function (Blueprint $table) {
            $table->id();
            $table->foreignId('FUNCIONARIO_ID')->constrained('FUNCIONARIOS')->onDelete('cascade');
            $table->foreignId('EPI_ID')->constrained('EPI')->onDelete('cascade');
            $table->date('DATA_ENTREGA');
            $table->date('VALIDADE')->nullable();
            $table->integer('QUANTIDADE')->default(1);
            $table->text('OBSERVACAO')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entregas_epi');
    }
};
