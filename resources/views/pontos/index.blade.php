@extends('layouts.app')

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/pontosTable.js') }}"></script>
<script src="{{ asset('js/modals/handleDeletePonto.js') }}"></script>

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Painel de Pontos
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie os registros de ponto dos funcionários.</p>
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
                        <button class="btn btn-white border shadow-sm dropdown-toggle d-flex align-items-center"
                            type="button" id="acoesDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="color: #000;">
                            Ações
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="acoesDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('pontos.pdfGeral') }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                    Gerar PDF de Pontos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('funcionarios.index') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Voltar para Funcionários
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white" id="pontosTable">
                        <thead class="table-light">
                            <tr>
                                <th>Funcionário</th>
                                <th>Setor</th>
                                <th>Data</th>
                                <th>Hora Entrada</th>
                                <th>Hora Saída</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pontos as $ponto)
                                <tr>
                                    <td>{{ $ponto->funcionario->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ $ponto->funcionario->setor->nome ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ponto->data)->format('d/m/Y') }}</td>
                                    <td>{{ $ponto->hora_entrada }}</td>
                                    <td>{{ $ponto->hora_saida }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $ponto->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $ponto->id }}">
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center text-danger"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal" data-pontoid="{{ $ponto->id }}">
                                                        <i class="bi bi-trash-fill me-2"></i> Excluir
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <form id="delete-form-{{ $ponto->id }}"
                                            action="{{ route('pontos.delete', $ponto->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este registro de ponto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection