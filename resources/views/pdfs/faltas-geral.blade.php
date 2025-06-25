<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório Geral de Faltas</title>
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
</style>
</head>
<body>

<h1>Relatório Geral de Faltas</h1>

@php
    // Agrupa faltas por nome do setor
    $faltasPorSetor = $faltas->groupBy(fn($f) => $f->funcionario->setor->nome ?? 'Sem Setor');
@endphp

@foreach($faltasPorSetor as $setorNome => $faltasSetor)
    <h2>Setor: {{ $setorNome }}</h2>

    @php
        // Dentro de cada setor, agrupa por funcionário
        $faltasPorFuncionario = $faltasSetor->groupBy(fn($f) => $f->funcionario->usuario->name ?? 'Sem Nome');
    @endphp

    @foreach($faltasPorFuncionario as $funcNome => $faltasFuncionario)
        <h3>Funcionário: {{ $funcNome }}</h3>

        <table>
            <thead>
                <tr>
                    <th class="center">Data</th>
                    <th class="center">Justificada</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faltasFuncionario as $falta)
                    <tr>
                        <td class="center">{{ \Carbon\Carbon::parse($falta->data)->format('d/m/Y') }}</td>
                        <td class="center">{{ $falta->justificado ? 'Sim' : 'Não' }}</td>
                        <td>{{ $falta->motivo ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endforeach

</body>
</html>
