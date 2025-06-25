<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório de Pontos - {{ $funcionario->usuario->name }}</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        color: #333;
        background: #fff;
        margin: 0;
        padding: 30px 25px 40px 25px;
    }

    h2 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 700;
        font-size: 28px;
        color: #2C3E50; 
        text-transform: uppercase;
        letter-spacing: 1.1px;
        user-select: none;
    }

    h4 {
        margin: 20px 0 25px 0;
        color: #566573; /* cinza azulado */
        font-weight: 600;
        text-align: center;
    }

    table {
        width: 100%;
        max-width: 900px;
        margin: 0 auto 30px auto;
        border-collapse: separate;
        border-spacing: 0 10px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    thead {
        background-color: #f0f4f8;
        color: #34495e;
        user-select: none;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    thead th {
        padding: 12px 15px;
        border-bottom: 2px solid #d6dde6;
        text-align: center;
    }

    thead th:first-child {
        text-align: left;
    }

    tbody tr {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        transition: background-color 0.25s ease;
    }

    tbody tr:hover {
        background-color: #f9fbfd;
    }

    tbody td {
        padding: 14px 15px;
        border-bottom: 1px solid #e1e8f0;
        text-align: center;
        font-weight: 500;
        font-size: 13px;
        color: #4a5a6a;
        vertical-align: middle;
    }

    tbody td:first-child {
        text-align: left;
        font-weight: 600;
        color: #2c3e50;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .empty-row td {
        padding: 25px;
        font-style: italic;
        color: #8c8c8c;
        font-weight: 400;
        text-align: center;
    }

    footer {
        position: fixed;
        bottom: 10px;
        width: 100%;
        text-align: center;
        font-size: 11px;
        color: #95a5a6;
        user-select: none;
    }
</style>
</head>
<body>

<h2>Relatório de Pontos - {{ $funcionario->usuario->name }}</h2>
<h4>Setor: {{ $funcionario->setor->nome ?? '---' }}</h4>

<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Hora de Entrada</th>
            <th>Hora de Saída</th>
            <th>Total de Horas</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pontos as $ponto)
            <tr>
                <td>{{ \Carbon\Carbon::parse($ponto->data)->format('d/m/Y') }}</td>
                <td>{{ $ponto->hora_entrada }}</td>
                <td>{{ $ponto->hora_saida ?? '---' }}</td>
                <td>
                    @if($ponto->hora_entrada && $ponto->hora_saida)
                        {{ \Carbon\Carbon::parse($ponto->hora_entrada)->diff(\Carbon\Carbon::parse($ponto->hora_saida))->format('%H:%I') }}
                    @else
                        ---
                    @endif
                </td>
            </tr>
        @empty
            <tr class="empty-row">
                <td colspan="4">Nenhum registro de ponto encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<footer>
    Página <span class="pageNumber"></span>
</footer>

</body>
</html>
