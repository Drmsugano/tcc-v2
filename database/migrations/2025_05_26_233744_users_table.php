<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('USUARIOS', function (Blueprint $table) {
            $table->id();
            $table->string('NOME');
            $table->string('CPF')->unique();
            $table->string('USUARIO');
            $table->string('EMAIL')->unique();
            $table->string('PASSWORD');
            $table->enum('PERFIL', ['ADMINISTRADOR', 'SEGURANCA DO TRABALHO','FUNCIONARIO'])->default('FUNCIONARIO');
            $table->foreignId('EMPRESA_ID')->nullable()->constrained('EMPRESAS')->nullOnDelete();
            $table->timestamp('EMAIL_VERIFIED_AT')->nullable();
            $table->date('DATA_NASCIMENTO');
            $table->date('DATA_ADMISSAO');
            $table->date('DATA_DEMISSAO')->nullable();
            $table->date('DATA_CADASTRO')->default(now());
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('USUARIOS');
    }
};
