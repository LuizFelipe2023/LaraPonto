<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório Geral de Atrasos</title>
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

<h1>Relatório Geral de Atrasos</h1>

@php
    // Agrupa atrasos por setor
    $atrasosPorSetor = $atrasos->groupBy(fn($a) => $a->funcionario->setor->nome ?? 'Sem Setor');
@endphp

@foreach($atrasosPorSetor as $setorNome => $atrasosSetor)
    <h2>Setor: {{ $setorNome }}</h2>

    @php
        // Dentro de cada setor, agrupa por funcionário
        $atrasosPorFuncionario = $atrasosSetor->groupBy(fn($a) => $a->funcionario->usuario->name ?? 'Sem Nome');
    @endphp

    @foreach($atrasosPorFuncionario as $funcNome => $atrasosFuncionario)
        <h3>Funcionário: {{ $funcNome }}</h3>

        <table>
            <thead>
                <tr>
                    <th class="center">Data</th>
                    <th class="center">Tempo Atraso</th>
                    <th class="center">Justificado</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atrasosFuncionario as $atraso)
                    <tr>
                        <td class="center">{{ \Carbon\Carbon::parse($atraso->data)->format('d/m/Y') }}</td>
                        <td class="center">{{ $atraso->tempo_atraso }}</td>
                        <td class="center">{{ $atraso->justificado ? 'Sim' : 'Não' }}</td>
                        <td>{{ $atraso->motivo ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endforeach

</body>
</html>
