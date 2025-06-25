@extends('layouts.app')

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/atrasosTable.js') }}"></script>
<script src="{{ asset('js/modals/handleDeleteAtraso.js') }}"></script>

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Painel de Atrasos
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie os atrasos registrados no sistema.</p>
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
                        <button class="btn btn-sm btn-white shadow-sm dropdown-toggle" type="button"
                            id="acoesAtrasosDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: #000;">
                            Ações
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="acoesAtrasosDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('atrasos.create') }}">
                                    <i class="bi bi-plus-circle me-2"></i>Novo Atraso
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('atrasos.pdf') }}"
                                    target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Gerar PDF de Atrasos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white" id="atrasosTable">
                        <thead class="table-light">
                            <tr>
                                <th>Funcionário</th>
                                <th>Setor</th>
                                <th>Data</th>
                                <th>Tempo de Atraso</th>
                                <th>Justificado</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atrasos as $atraso)
                                <tr>
                                    <td>{{ $atraso->funcionario->usuario->name ?? '—' }}</td>
                                    <td>{{ $atraso->funcionario->setor->nome ?? '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atraso->data)->format('d/m/Y') }}</td>
                                    <td>{{ $atraso->tempo_atraso }}</td>
                                    <td>
                                        @if($atraso->justificado)
                                            <span class="badge bg-success">Sim</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Não</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownAtraso{{ $atraso->id }}" data-bs-toggle="dropdown">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownAtraso{{ $atraso->id }}">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('atrasos.edit', $atraso->id) }}">
                                                        <i class="bi bi-pencil-fill me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center text-danger"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal" data-atrasoid="{{ $atraso->id }}">
                                                        <i class="bi bi-trash-fill me-2"></i>Excluir
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <form id="delete-form-{{ $atraso->id }}" action="{{ route('atrasos.destroy', $atraso->id) }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
                    Tem certeza que deseja excluir este atraso?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection