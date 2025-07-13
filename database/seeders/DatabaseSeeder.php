<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // DB::table('EMPRESAS')->insert([
            // 'NOME' => 'SHINRA',
            // 'EMAIL' => 'contato@shinra.com',
            // 'RAZAO_SOCIAL' => 'SHINRA ENERGIA LTDA',
            // 'NOME_FANTASIA' => 'SHINRA ENERGIA',
            // 'CNPJ' => '00.000.000/0001-91',
            // 'ENDERECO' => 'Rua Exemplo, 123',
            // 'TELEFONE' => '(11) 1234-5678'
        // ]);
        DB::table('USUARIOS')->insert([
            'NOME' => 'DOUGLAS',
            'USUARIO' => 'DRMSUGANO',
            'CPF' => bcrypt('800.221.019-00'),
            'EMAIL' => 'drmsugano@outlook.com',
            'PASSWORD' => bcrypt('123'),
            'PERFIL' => 'ADMINISTRADOR'
        ]);
    }
}
