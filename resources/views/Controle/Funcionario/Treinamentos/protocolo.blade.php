<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Protocolo de Treinamento</title>

    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
        }

        .titulo {
            text-align: center;
            margin-bottom: 10px;
        }

        .titulo h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #222;
        }

        .subtitulo {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 25px;
        }

        .info-box {
            border: 1px solid #999;
            padding: 15px;
            border-radius: 6px;
            background: #f9f9f9;
            margin-bottom: 25px;
        }

        .info-box p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eaeaea;
        }

        .assinaturas {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .assinatura-item {
            width: 45%;
        }

        .linha-assinatura {
            margin-top: 50px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 13px;
        }

        .data-footer {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="titulo">
        <h1>PROTOCOLO DE TREINAMENTO</h1>
    </div>

    <div class="subtitulo">
        Comprovante de realização do treinamento obrigatório
    </div>

    <div class="info-box">
        <p><strong>Funcionário:</strong> {{ $funcionario->NOME }}</p>
        <p><strong>CPF:</strong> {{ $funcionario->CPF }}</p>
        <p><strong>Empresa:</strong> {{ $empresa->RAZAO_SOCIAL }}</p>
        <p><strong>Responsável pelo Registro:</strong> {{ $usuarioResponsavel->NOME }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Treinamento</th>
                <th>Data Realização</th>
                <th>Validade</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $funcionarioTreinamento->treinamento->NOME }}</td>
                <td>{{ \Carbon\Carbon::parse($funcionarioTreinamento->DATA_REALIZACAO)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($funcionarioTreinamento->DATA_VALIDADE)->format('d/m/Y') }}</td>
                <td>{{ $usuarioResponsavel->NOME }}</td>
            </tr>
        </tbody>
    </table>

    <div class="assinaturas">
        <div class="assinatura-item">
            <div class="linha-assinatura">Assinatura do Funcionário</div>
        </div>

        <div class="assinatura-item">
            <div class="linha-assinatura">Assinatura do Responsável</div>
        </div>
    </div>

    <div class="data-footer">
        Data: {{ date('d/m/Y') }}
    </div>
        <footer>
            <p style="text-align: center; font-size: 12px; color: #777; margin-top: 50px;">
                Emitido por {{ $usuarioView['NOME'] }} - {{ date('d/m/Y H:i:s') }}
            </p>
        </footer>
</body>

</html>