@extends('layouts.app')

@section('content')
<div class="container-md mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg rounded-2">
                <div class="card-header text-center rounded-top">
                    <h1 class="fw-bold mb-0">Cadastro de Funcionário</h1>
                    <small class="d-block mt-1">Preencha os dados para criar o funcionário</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('funcionarios.store') }}" method="POST" id="storeFuncionario">
                        @csrf
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="user_id" class="fw-semibold text-dark">Usuário</label>
                                <select name="user_id" id="user_id" class="form-select shadow-sm" required>
                                    <option value="">Selecione um Usuário</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->name }} ({{ $usuario->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="setor_id" class="fw-semibold text-dark">Setor</label>
                                <select name="setor_id" id="setor_id" class="form-select shadow-sm" required>
                                    <option value="">Selecione um Setor</option>
                                    @foreach ($setores as $setor)
                                        <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>
                                            {{ $setor->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="cargo" class="fw-semibold text-dark">Cargo</label>
                                <input type="text" name="cargo" id="cargo" class="form-control shadow-sm" value="{{ old('cargo') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="salario" class="fw-semibold text-dark">Salário</label>
                                <input type="number" step="0.01" name="salario" id="salario" class="form-control shadow-sm" value="{{ old('salario') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="data_admissao" class="fw-semibold text-dark">Data de Admissão</label>
                                <input type="date" name="data_admissao" id="data_admissao" class="form-control shadow-sm" value="{{ old('data_admissao') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="status_id" class="fw-semibold text-dark">Status</label>
                                <select name="status_id" id="status_id" class="form-select shadow-sm" required>
                                    <option value="">Selecione o Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('funcionarios.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
