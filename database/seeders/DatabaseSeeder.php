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
        DB::table('EMPRESA')->insert([
            'RAZAO_SOCIAL' => 'SHINRA ENERGIA LTDA',
            'NOME_FANTASIA' => 'SHINRA ENERGIA',
            'CNPJ_CPF' => '00.000.000/0001-91'
        ]);
        DB::table('USUARIOS')->insert([
            'NOME' => 'DOUGLAS',
            'USUARIO' => 'DRMSUGANO',
            'EMAIL' => 'drmsugano@outlook.com',
            'PASSWORD' => bcrypt('123'),
            'ROSFIELD_ADMIN' => true,
            'ROSFIELD_USER' => true,
            'EMPRESA_ID' => 1
        ]);
    }
}
