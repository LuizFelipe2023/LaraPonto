@extends('layouts.app')

@section('content')
    <div class="container-md mt-4 mb-5">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Pontos do Funcionário
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie os registros de ponto de
                            <strong>{{ $funcionario->usuario->name ?? 'N/A' }}</strong>
                        </p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="d-flex justify-content-center mb-3">
                    <div class="dropdown">
                        <button class="btn btn-md btn-white shadow-sm dropdown-toggle" type="button" id="acoesDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color: #000;">
                            Ações
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="acoesDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('pontos.createEntrada', $funcionario->id) }}">
                                    Registrar Entrada
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white" id="pontosFuncionarioTable">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Hora Entrada</th>
                                <th>Hora Saída</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pontos as $ponto)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ponto->data)->format('d/m/Y') }}</td>
                                    <td>{{ $ponto->hora_entrada }}</td>
                                    <td>{{ $ponto->hora_saida ?? '-' }}</td>
                                    <td>
                                        @if (is_null($ponto->hora_saida))
                                            <a href="{{ route('pontos.createSaida', $funcionario->id) }}"
                                                class="btn btn-sm btn-success">
                                                Registrar Saída
                                            </a>
                                        @else
                                            <span class="text-muted">Saída registrada</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @if($pontos->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum ponto registrado para este funcionário.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

    <script>
        $(document).ready(function () {
            $('#pontosFuncionarioTable').DataTable({
                language: {
                    decimal: "",
                    emptyTable: "Nenhum dado disponível na tabela",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros no total)",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ registros",
                    loadingRecords: "Carregando...",
                    processing: "Processando...",
                    search: "Buscar:",
                    zeroRecords: "Nenhum registro correspondente encontrado",
                    paginate: {
                        first: "Primeiro",
                        last: "Último",
                        next: "Próximo",
                        previous: "Anterior"
                    },
                    aria: {
                        sortAscending: ": ativar para ordenar a coluna em ordem crescente",
                        sortDescending: ": ativar para ordenar a coluna em ordem decrescente"
                    }
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                ordering: true,
                order: [[0, 'desc']],
                responsive: true
            });
        });
    </script>
@endsection