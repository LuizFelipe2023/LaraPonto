<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório Geral de Pontos</title>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 30px;
        color: #2c3e50;
    }
    h1, h2, h3 {
        margin: 0 0 10px 0;
        color: #34495e;
    }
    h1 {
        font-size: 22px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        text-align: center;
        margin-bottom: 40px;
    }
    h2 {
        font-size: 18px;
        margin-top: 40px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 6px;
    }
    h3 {
        font-size: 14px;
        margin-top: 25px;
        color: #5d6d7e;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 15px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 6px 8px;
        text-align: left;
        vertical-align: middle;
    }
    th {
        background-color: #f7f9fb;
        font-weight: bold;
        text-align: center;
        border-color: #bbb;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .center {
        text-align: center;
    }
    .total-row {
        font-weight: bold;
        background-color: #e1f5fe;
    }
</style>
</head>
<body>

<h1>Relatório Geral de Pontos</h1>

@php
    $pontosPorSetor = $pontos->groupBy(fn($p) => $p->funcionario->setor->nome ?? 'Sem Setor');
@endphp

@foreach($pontosPorSetor as $setorNome => $pontosSetor)
    <h2>Setor: {{ $setorNome }}</h2>

    @php
        $pontosPorFuncionario = $pontosSetor->groupBy(fn($p) => $p->funcionario->usuario->name ?? 'Sem Nome');
    @endphp

    @foreach($pontosPorFuncionario as $funcionarioNome => $pontosFuncionario)
        <h3>Funcionário: {{ $funcionarioNome }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora Entrada</th>
                    <th>Hora Saída</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalHorasSegundos = 0;
                @endphp

                @foreach($pontosFuncionario as $ponto)
                    @php
                        $entrada = $ponto->hora_entrada ? \Carbon\Carbon::parse($ponto->hora_entrada) : null;
                        $saida = $ponto->hora_saida ? \Carbon\Carbon::parse($ponto->hora_saida) : null;
                        $diffSegundos = ($entrada && $saida) ? $saida->diffInSeconds($entrada) : 0;
                        $totalHorasSegundos += $diffSegundos;
                    @endphp
                    <tr>
                        <td class="center">{{ \Carbon\Carbon::parse($ponto->data)->format('d/m/Y') }}</td>
                        <td class="center">{{ $entrada ? $entrada->format('H:i:s') : '---' }}</td>
                        <td class="center">{{ $saida ? $saida->format('H:i:s') : '---' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endforeach

</body>
</html>
