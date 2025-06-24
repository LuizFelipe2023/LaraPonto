@extends('layouts.app')
<script src="{{ asset('js/modals/handleDeleteUser.js') }}"></script>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/usersTable.js') }}"></script>
@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-1">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col text-center">
                        <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                            Painel de Usuários
                            <span class="title-underline"></span>
                        </h1>
                        <p class="text-muted fs-5">Gerencie os usuários do sistema abaixo.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="card bg-white shadow-sm border-1 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">Total de Usuários</h5>
                                <p class="display-6">{{ $users->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-white shadow-sm border-1 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">Administradores</h5>
                                <p class="display-6">{{ $users->where('tipo_usuario', 1)->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-white shadow-sm border-1 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">Colaboradores</h5>
                                <p class="display-6">{{ $users->whereIn('tipo_usuario', [2, 3])->count() }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-5">
                    <div class="col">
                        <div class="card bg-white shadow-sm border-1">
                            <div class="card-body">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label for="tipo_usuario" class="fw-semibold text-dark mb-1">Filtrar por Tipo de
                                            Usuário</label>
                                        <div class="input-group shadow-sm">
                                            <select name="tipo_usuario" id="tipo_usuario" class="form-select">
                                                <option value="">Todos os Tipos</option>
                                                @foreach ($tipoUsuarios as $tipoUsuario)
                                                    <option value="{{ $tipoUsuario->nome }}">{{ $tipoUsuario->nome }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text bg-white"><i class="bi bi-funnel"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-hover align-middle bg-white">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Tipo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->tipoUsuario->nome ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Ações
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="{{ route('users.edit', $user->id) }}">
                                                                    <i class="bi bi-pencil-fill me-2"></i> Editar
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    class="dropdown-item d-flex align-items-center text-danger"
                                                                    type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#confirmDeleteModal"
                                                                    data-userid="{{ $user->id }}">
                                                                    <i class="bi bi-trash-fill me-2"></i> Excluir
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('users.delete', $user->id) }}" method="POST"
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
                    Tem certeza que deseja excluir este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>

@endsection