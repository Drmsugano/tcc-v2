<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Protocolo de Entrega de EPI</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 24px;
            color: #0d6efd;
        }

        .subtitulo {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }

        .texto {
            line-height: 1.6;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 13px;
        }

        th {
            background-color: #f0f4ff;
            color: #0d6efd;
            border: 1px solid #bbb;
            padding: 8px;
            font-weight: bold;
            text-align: left;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .linha-assinatura {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .assinatura-box {
            width: 45%;
            text-align: center;
        }

        .linha {
            margin-top: 50px;
            border-bottom: 1px solid #000;
            width: 100%;
        }

        .titulo-assinatura {
            margin-top: 5px;
            font-size: 13px;
            color: #444;
        }

        .rodape-data {
            margin-top: 60px;
            font-size: 14px;
        }

        .empresa-header {
            text-align: right;
            font-size: 14px;
            color: #555;
        }

    </style>
</head>
<body>

    <div class="empresa-header">
        <strong>{{ $empresa->RAZAO_SOCIAL ?? '' }}</strong><br>
        CNPJ: {{ $empresa->CNPJ_CPF ?? '' }}
    </div>

    <h1>PROTOCOLO DE ENTREGA DE EPI</h1>
    <div class="subtitulo">Documento de comprovação e responsabilidade</div>

    <p class="texto">
        Eu, <strong>{{ $funcionarioEpi->NOME_FUNCIONARIO ?? '_________________________' }}</strong>, portador(a) do CPF nº 
        <strong>{{ $funcionarioEpi->CPF_FUNCIONARIO ?? '________________' }}</strong>, declaro ter recebido da empresa 
        <strong>{{ $empresa->RAZAO_SOCIAL ?? '_________________________' }}</strong> os Equipamentos de Proteção Individual (EPI) abaixo relacionados. 
        Estou ciente das orientações referentes ao uso adequado, conservação e responsabilidade pela guarda dos materiais recebidos.
    </p>

    <table>
        <thead>
            <tr>
                <th>EPI</th>
                <th>CA</th>
                <th>Quantidade</th>
                <th>Data Entrega</th>
                <th>Assinatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($epis as $epi)
            <tr>
                <td>{{ $epi->NOME_EPI }}</td>
                <td>{{ $epi->CA }}</td>
                <td>{{ $epi->QUANTIDADE }}</td>
                <td>{{ \Carbon\Carbon::parse($epi->DATA_ENTREGA)->format('d/m/Y') }}</td>
                <td style="height: 35px;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="linha-assinatura">
        <div class="assinatura-box">
            <div class="linha"></div>
            <div class="titulo-assinatura">Assinatura do Funcionário</div>
        </div>

        <div class="assinatura-box">
            <div class="linha"></div>
            <div class="titulo-assinatura">Assinatura do Responsável</div>
        </div>
    </div>

    <p class="rodape-data">
        Data: ____/____/________
    </p>
    <footer>
        <p>
            @ {{ date('Y') }} {{ $empresa->RAZAO_SOCIAL ?? '' }}. Todos os direitos reservados.
        </p>
    </footer>
</body>
</html>
