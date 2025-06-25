@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
    <div class="container-md mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg rounded-2">
                    <div class="card-header text-center rounded-top">
                        <h1 class="fw-bold mb-0">Registrar Atraso</h1>
                        <small class="d-block mt-1">Preencha os dados do atraso</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('atrasos.store') }}" method="POST" id="createAtraso">
                            @csrf
                            <div class="row g-4">
                                {{-- Seleção de Funcionário --}}
                                <div class="col-md-6">
                                    <label for="funcionario_id" class="fw-semibold text-dark">Funcionário</label>
                                    <select name="funcionario_id" id="funcionario_id" class="form-select shadow-sm" required>
                                        <option value="">Selecione um Funcionário</option>
                                        @foreach($funcionarios as $f)
                                            <option value="{{ $f->id }}" {{ old('funcionario_id') == $f->id ? 'selected' : '' }}>
                                                {{ $f->usuario->name }} — {{ $f->setor->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="data" class="fw-semibold text-dark">Data</label>
                                    <input type="date" name="data" id="data" class="form-control shadow-sm" value="{{ old('data', now()->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tempo_atraso" class="fw-semibold text-dark">Tempo de Atraso</label>
                                    <input type="text" name="tempo_atraso" id="tempo_atraso" class="form-control shadow-sm" placeholder="ex: 00:15 ou 15 minutos" value="{{ old('tempo_atraso') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="justificado" class="fw-semibold text-dark">Justificado?</label>
                                    <select name="justificado" id="justificado" class="form-select shadow-sm" required>
                                        <option value="0" {{ old('justificado')=='0'?'selected':'' }}>Não</option>
                                        <option value="1" {{ old('justificado')=='1'?'selected':'' }}>Sim</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="motivo" class="fw-semibold text-dark">Motivo (opcional)</label>
                                    <textarea name="motivo" id="motivo" rows="3" class="form-control shadow-sm">{{ old('motivo') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('atrasos.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-sm btn-primary">Salvar Atraso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
