<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório de Auditorias</title>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 30px;
        color: #2c3e50;
    }
    h1 {
        font-size: 22px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        text-align: center;
        margin-bottom: 40px;
        color: #34495e;
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
    pre {
        white-space: pre-wrap; 
        word-wrap: break-word;
        margin: 0;
        font-family: monospace;
        font-size: 11px;
    }
</style>
</head>
<body>

<h1>Relatório de Auditorias</h1>

<table>
    <thead>
        <tr>
            <th class="center" style="width: 15%;">Data</th>
            <th class="center" style="width: 25%;">Usuário</th>
            <th class="center" style="width: 20%;">Ação</th>
            <th>Detalhes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($audits as $audit)
            <tr>
                <td class="center">{{ \Carbon\Carbon::parse($audit->created_at)->format('d/m/Y H:i') }}</td>
                <td class="center">{{ $audit->user->name ?? 'Usuário desconhecido' }}</td>
                <td class="center">{{ $audit->acao }}</td>
                <td>
                    @if(is_array($audit->detalhes) || is_object($audit->detalhes))
                        <pre>{{ json_encode($audit->detalhes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @else
                        {{ $audit->detalhes ?? '—' }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
