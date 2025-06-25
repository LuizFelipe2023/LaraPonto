@extends('layouts.app')
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/faltasTable.js') }}"></script>
<script src="{{ asset('js/modals/handleDeleteFalta.js') }}"></script>
@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Painel de Faltas
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie as faltas registradas no sistema.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="d-flex justify-content-center mb-3">
                    <a href="{{ route('faltas.create') }}" class="btn btn-sm btn-success shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i>Nova Falta
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white" id="faltasTable">
                        <thead class="table-light">
                            <tr>
                                <th>Funcionário</th>
                                <th>Setor</th>
                                <th>Data</th>
                                <th>Justificada</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faltas as $falta)
                                <tr>
                                    <td>{{ $falta->funcionario->usuario->name ?? '—' }}</td>
                                    <td>{{ $falta->funcionario->setor->nome ?? '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($falta->data)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($falta->justificado)
                                            <span class="badge bg-success">Sim</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Não</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownFalta{{ $falta->id }}" data-bs-toggle="dropdown">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownFalta{{ $falta->id }}">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('faltas.edit', $falta->id) }}">
                                                        <i class="bi bi-pencil-fill me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center text-danger"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal" data-faltaid="{{ $falta->id }}">
                                                        <i class="bi bi-trash-fill me-2"></i>Excluir
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <form id="delete-form-{{ $falta->id }}" action="{{ route('faltas.destroy', $falta->id) }}"
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