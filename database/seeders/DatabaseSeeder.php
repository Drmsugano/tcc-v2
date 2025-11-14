<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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
            'PUBLIC_ID' => Str::uuid(),
            'NOME_FANTASIA' => 'SHINRA ENERGIA',
            'CNPJ_CPF' => '00.000.000/0001-91'
        ]);

        // -----------------------
        // Permissões
        // -----------------------
        DB::table('PERMISSOES')->insert([
            ['NOME_PERMISSAO' => 'ADMIN', 'DESCRICAO' => 'Acesso total ao sistema', 'PUBLIC_ID' => Str::uuid()],
            ['NOME_PERMISSAO' => 'USER', 'DESCRICAO' => 'Usuário comum', 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'CONTROLE', 'DESCRICAO' => 'Acesso a controle de operações', 'PUBLIC_ID' => Str::uuid(),],
            ['NOME_PERMISSAO' => 'ENGENHARIA', 'DESCRICAO' => 'Acesso ao módulo de engenharia', 'PUBLIC_ID' => Str::uuid()],
            ['NOME_PERMISSAO' => 'MASTER', 'DESCRICAO' => 'Permissão master', 'PUBLIC_ID' => Str::uuid()]
        ]);

        // -----------------------
        // Usuário Admin
        // -----------------------
        DB::table('USUARIOS')->insert([
            'NOME' => 'DOUGLAS',
            'PUBLIC_ID' => Str::uuid(),
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
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 4], // ENGENHARIA
        ]);

        // -----------------------
        // Setores
        // -----------------------
        DB::table('SETOR')->insert([
            ['NOME' => 'Administração', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Produção', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenharia', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()]
        ]);

        // -----------------------
        // Funções
        // -----------------------
        DB::table('FUNCAO')->insert([
            ['NOME' => 'Gerente Administrativo', 'SETOR_ID' => 1, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Auxiliar de Produção', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Operador de Máquinas', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Técnico de Segurança do Trabalho', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenheiro de Produção', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenheiro de Segurança do Trabalho', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenheiro Mecânico', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenheiro Eletricista', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Pedreiro', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenheiro Civil', 'SETOR_ID' => 3, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()]
        ]);

        // -----------------------
        // Obras
        // -----------------------
        DB::table('OBRA')->insert([
            ['NOME_OBRA' => 'Obra Central', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME_OBRA' => 'Obra Norte', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()]
        ]);

        // -----------------------
        // Funcionários
        // -----------------------

        // -----------------------
        // EPIs
        // -----------------------

        // -----------------------
        // Relacionamento Funcionário <-> Obra
        // -----------------------

        // -----------------------
        // Entrega de EPIs
        // -----------------------
        DB::table('TIPO_DOCUMENTO')->insert([
            ['NOME' => 'EXCEL', 'DESCRICAO' => 'Planilha em formato Excel (.xls ou .xlsx)'],
            ['NOME' => 'WORD', 'DESCRICAO' => 'Documento em formato Word (.doc ou .docx)'],
            ['NOME' => 'PDF', 'DESCRICAO' => 'Documento em formato PDF'],
        ]);
        DB::table('TIPO_FORNECEDOR')->insert([
            ['NOME_TIPO' => 'MATERIAL DE CONSTRUÇÃO', 'DESCRICAO_TIPO' => 'Fornecedores de materiais de construção'],
            ['NOME_TIPO' => 'EPI', 'DESCRICAO_TIPO' => 'Fornecedores de Equipamentos de Proteção Individual'],
            ['NOME_TIPO' => 'FERRAMENTA', 'DESCRICAO_TIPO' => 'Fornecedores de ferramentas'],
            ['NOME_TIPO' => 'MAQUINARIO', 'DESCRICAO_TIPO' => 'Fornecedores de maquinários'],
        ]);
    }
}
