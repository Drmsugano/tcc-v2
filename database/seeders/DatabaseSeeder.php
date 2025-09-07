<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -----------------------
        // Empresa
        // -----------------------
        DB::table('EMPRESA')->insert([
            'RAZAO_SOCIAL' => 'SHINRA ENERGIA LTDA',
            'NOME_FANTASIA' => 'SHINRA ENERGIA',
            'CNPJ_CPF' => '00.000.000/0001-91'
        ]);

        // -----------------------
        // Permissões
        // -----------------------
        DB::table('PERMISSOES')->insert([
            ['NOME' => 'ADMIN', 'DESCRICAO' => 'Acesso total ao sistema'],
            ['NOME' => 'USER', 'DESCRICAO' => 'Usuário comum'],
            ['NOME' => 'CONTROLE', 'DESCRICAO' => 'Acesso a controle de operações'],
            ['NOME' => 'FINANCEIRO', 'DESCRICAO' => 'Acesso financeiro'],
            ['NOME' => 'COMPRAS', 'DESCRICAO' => 'Acesso ao módulo de compras'],
            ['NOME' => 'ENGENHARIA', 'DESCRICAO' => 'Acesso ao módulo de engenharia'],
            ['NOME' => 'MASTER', 'DESCRICAO' => 'Permissão master']
        ]);

        // -----------------------
        // Usuário Admin
        // -----------------------
        DB::table('USUARIOS')->insert([
            'NOME' => 'DOUGLAS',
            'USUARIO' => 'DRMSUGANO',
            'EMAIL' => 'drmsugano@outlook.com',
            'PASSWORD' => Hash::make('123'),
            'EMPRESA_ID' => 1
        ]);

        // -----------------------
        // Vinculando usuário às permissões
        // -----------------------
        DB::table('USUARIO_PERMISSAO')->insert([
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 1], // ADMIN
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 2], // USER
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 3], // CONTROLE
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 4], // FINANCEIRO
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 5], // COMPRAS
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 6], // ENGENHARIA
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 7]  // MASTER
        ]);

        // -----------------------
        // Setores
        // -----------------------
        DB::table('SETOR')->insert([
            ['NOME' => 'Administração', 'EMPRESA_ID' => 1],
            ['NOME' => 'Financeiro', 'EMPRESA_ID' => 1],
            ['NOME' => 'Engenharia', 'EMPRESA_ID' => 1]
        ]);

        // -----------------------
        // Funções
        // -----------------------
        DB::table('FUNCAO')->insert([
            ['NOME' => 'Gerente Administrativo', 'SETOR_ID' => 1, 'EMPRESA_ID' => 1],
            ['NOME' => 'Analista Financeiro', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1],
            ['NOME' => 'Engenheiro Civil', 'SETOR_ID' => 3, 'EMPRESA_ID' => 1]
        ]);

        // -----------------------
        // Obras
        // -----------------------
        DB::table('OBRA')->insert([
            ['NOME_OBRA' => 'Obra Central', 'EMPRESA_ID' => 1],
            ['NOME_OBRA' => 'Obra Norte', 'EMPRESA_ID' => 1]
        ]);

        // -----------------------
        // Funcionários
        // -----------------------
        DB::table('FUNCIONARIOS')->insert([
            [
                'NOME' => 'Carlos Silva',
                'CPF' => '111.111.111-11',
                'DATA_ADMISSAO' => '2025-01-10',
                'EMPRESA_ID' => 1,
                'FUNCAO_ID' => 1
            ],
            [
                'NOME' => 'Ana Souza',
                'CPF' => '222.222.222-22',
                'DATA_ADMISSAO' => '2025-02-15',
                'EMPRESA_ID' => 1,
                'FUNCAO_ID' => 2
            ],
            [
                'NOME' => 'Pedro Lima',
                'CPF' => '333.333.333-33',
                'DATA_ADMISSAO' => '2025-03-01',
                'EMPRESA_ID' => 1,
                'FUNCAO_ID' => 3
            ]
        ]);

        // -----------------------
        // EPIs
        // -----------------------
        DB::table('EPI')->insert([
            [
                'NOME' => 'Capacete',
                'DESCRICAO' => 'Capacete de segurança tipo A',
                'CA' => '12345',
                'VALIDADE_EPI' => '2030-12-31',
                'USUARIO_CADASTRO' => 1,
                'USUARIO_ALTERACAO' => 1
            ],
            [
                'NOME' => 'Luvas',
                'DESCRICAO' => 'Luvas resistentes a corte',
                'CA' => '67890',
                'VALIDADE_EPI' => '2030-12-31',
                'USUARIO_CADASTRO' => 1,
                'USUARIO_ALTERACAO' => 1
            ]
        ]);

        // -----------------------
        // Relacionamento Funcionário <-> Obra
        // -----------------------
        DB::table('FUNCIONARIO_OBRA')->insert([
            ['FUNCIONARIO_ID' => 1, 'OBRA_ID' => 1],
            ['FUNCIONARIO_ID' => 2, 'OBRA_ID' => 2],
            ['FUNCIONARIO_ID' => 3, 'OBRA_ID' => 1]
        ]);

        // -----------------------
        // Entrega de EPIs
        // -----------------------
        DB::table('FUNCIONARIO_EPI')->insert([
            [
                'FUNCIONARIO_ID' => 1,
                'EPI_ID' => 1,
                'QUANTIDADE' => 1,
                'DATA_ENTREGA' => '2025-04-01',
                'RESPONSAVEL_ENTREGA' => 1
            ],
            [
                'FUNCIONARIO_ID' => 2,
                'EPI_ID' => 2,
                'QUANTIDADE' => 2,
                'DATA_ENTREGA' => '2025-04-02',
                'RESPONSAVEL_ENTREGA' => 1
            ]
        ]);
    }
}
