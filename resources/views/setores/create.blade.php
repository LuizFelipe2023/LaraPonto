@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
<div class="container-md mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-2">
                <div class="card-header text-center rounded-top">
                    <h1 class="fw-bold mb-0">Cadastro de Setor</h1>
                    <small class="d-block mt-1">Preencha os dados para criar um novo setor</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('setores.store') }}" method="POST" id="formSetor">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="fw-semibold text-dark">Nome do Setor</label>
                            <input type="text" name="nome" id="nome" class="form-control shadow-sm" value="{{ old('nome') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gestor_id" class="fw-semibold text-dark">Gestor</label>
                            <select name="gestor_id" id="gestor_id" class="form-select shadow-sm" required>
                                <option value="">Selecione um Gestor</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('gestor_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('setores.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
