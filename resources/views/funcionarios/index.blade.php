@extends('layouts.app')

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/funcionariosTable.js') }}"></script>
<script src="{{ asset('js/modals/handleDeleteFuncionario.js') }}"></script>
@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Painel de Funcionários
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie os funcionários cadastrados no sistema.</p>
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
                        <button class="btn dropdown-toggle shadow-sm" type="button" id="filtrosDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Ações e Filtros
                        </button>
                        <div class="dropdown-menu p-4" style="min-width: 300px;">

                            <div class="mb-3">
                                <label for="setor_filtro" class="fw-semibold text-dark mb-1">Filtrar por Setor</label>
                                <select name="setor_filtro" id="setor_filtro" class="form-select">
                                    <option value="">Todos os Setores</option>
                                    @foreach ($setores as $setor)
                                        <option value="{{ $setor->nome }}">{{ $setor->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status_filtro" class="fw-semibold text-dark mb-1">Filtrar por Status</label>
                                <select name="status_filtro" id="status_filtro" class="form-select">
                                    <option value="">Todos os Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->nome }}">{{ $status->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('funcionarios.create') }}" class="btn btn-success">
                                    <i class="bi bi-plus-circle me-2"></i> Cadastrar Funcionário
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Setor</th>
                                <th>Cargo</th>
                                <th>Salário</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($funcionarios as $funcionario)
                                <tr>
                                    <td>{{ $funcionario->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ $funcionario->setor->nome ?? 'N/A' }}</td>
                                    <td>{{ $funcionario->cargo }}</td>
                                    <td>R$ {{ number_format($funcionario->salario, 2, ',', '.') }}</td>
                                    <td>{{ $funcionario->status->nome ?? 'N/A' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $funcionario->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $funcionario->id }}">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('funcionarios.edit', $funcionario->id) }}">
                                                        <i class="bi bi-pencil-fill me-2"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center text-danger"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-funcionarioid="{{ $funcionario->id }}">
                                                        <i class="bi bi-trash-fill me-2"></i> Excluir
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('pontos.funcionario', $funcionario->id) }}">
                                                        <i class="bi bi-clock-history me-2"></i> Ver Pontos
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <form id="delete-form-{{ $funcionario->id }}"
                                            action="{{ route('funcionarios.delete', $funcionario->id) }}" method="POST"
                                            class="d-none">
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
                    Tem certeza que deseja excluir este funcionário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection