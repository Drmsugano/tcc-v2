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
            ['NOME_PERMISSAO' => 'FINANCEIRO', 'DESCRICAO' => 'Acesso financeiro', 'PUBLIC_ID' => Str::uuid(),],
            ['NOME_PERMISSAO' => 'COMPRAS', 'DESCRICAO' => 'Acesso ao módulo de compras', 'PUBLIC_ID' => Str::uuid()],
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
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 4], // FINANCEIRO
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 5], // COMPRAS
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 6], // ENGENHARIA
            ['USUARIO_ID' => 1, 'PERMISSAO_ID' => 7]  // MASTER
        ]);

        // -----------------------
        // Setores
        // -----------------------
        DB::table('SETOR')->insert([
            ['NOME' => 'Administração', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Financeiro', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Engenharia', 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()]
        ]);

        // -----------------------
        // Funções
        // -----------------------
        DB::table('FUNCAO')->insert([
            ['NOME' => 'Gerente Administrativo', 'SETOR_ID' => 1, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
            ['NOME' => 'Analista Financeiro', 'SETOR_ID' => 2, 'EMPRESA_ID' => 1, 'PUBLIC_ID' => Str::uuid()],
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
        DB::table('FUNCIONARIOS')->insert([
            [
                'NOME' => 'Carlos Silva',
                'CPF' => '111.111.111-11',
                'DATA_ADMISSAO' => '2025-01-10',
                'PUBLIC_ID' => Str::uuid(),
                'EMPRESA_ID' => 1,
                'FUNCAO_ID' => 1
            ],
            [
                'NOME' => 'Ana Souza',
                'CPF' => '222.222.222-22',
                'DATA_ADMISSAO' => '2025-02-15',
                'PUBLIC_ID' => Str::uuid(),
                'EMPRESA_ID' => 1,
                'FUNCAO_ID' => 2
            ],
            [
                'NOME' => 'Pedro Lima',
                'CPF' => '333.333.333-33',
                'PUBLIC_ID' => Str::uuid(),
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
                'PUBLIC_ID' => Str::uuid(),
                'VALIDADE_EPI' => '2030-12-31',
                'USUARIO_CADASTRO' => 1,
                'USUARIO_ALTERACAO' => 1
            ],
            [
                'NOME' => 'Luvas',
                'DESCRICAO' => 'Luvas resistentes a corte',
                'CA' => '67890',
                'PUBLIC_ID' => Str::uuid(),
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
        DB::table('TIPO_DOCUMENTO')->insert([
            ['NOME' => 'PDF', 'DESCRICAO' => 'Documento em formato PDF'],
            ['NOME' => 'WORD', 'DESCRICAO' => 'Documento em formato Word (.doc ou .docx)'],
            ['NOME' => 'EXCEL', 'DESCRICAO' => 'Planilha em formato Excel (.xls ou .xlsx)'],
            ['NOME' => 'IMAGEM', 'DESCRICAO' => 'Arquivo de imagem (JPG, PNG, etc.)'],
            ['NOME' => 'TXT', 'DESCRICAO' => 'Arquivo de texto simples'],
            ['NOME' => 'PPT', 'DESCRICAO' => 'Apresentação em PowerPoint'],
        ]);
    }
}
