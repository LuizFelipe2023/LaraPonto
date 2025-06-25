@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
    <div class="container-md mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg rounded-2">
                    <div class="card-header text-center rounded-top">
                        <h1 class="fw-bold mb-0">Editar Atraso</h1>
                        <small class="d-block mt-1">Atualize os dados do atraso</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('atrasos.update', $atraso->id) }}" method="POST" id="editAtraso">
                            @csrf @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="fw-semibold text-dark">Funcionário</label>
                                    <input type="text" class="form-control shadow-sm" 
                                           value="{{ $atraso->funcionario->usuario->name }} — {{ $atraso->funcionario->setor->nome }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="data" class="fw-semibold text-dark">Data</label>
                                    <input type="date" name="data" id="data" class="form-control shadow-sm"
                                           value="{{ old('data', $atraso->data->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tempo_atraso" class="fw-semibold text-dark">Tempo de Atraso</label>
                                    <input type="text" name="tempo_atraso" id="tempo_atraso" class="form-control shadow-sm"
                                           value="{{ old('tempo_atraso', $atraso->tempo_atraso) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="justificado" class="fw-semibold text-dark">Justificado?</label>
                                    <select name="justificado" id="justificado" class="form-select shadow-sm" required>
                                        <option value="0" {{ old('justificado', $atraso->justificado)=='0'?'selected':'' }}>Não</option>
                                        <option value="1" {{ old('justificado', $atraso->justificado)=='1'?'selected':'' }}>Sim</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="motivo" class="fw-semibold text-dark">Motivo (opcional)</label>
                                    <textarea name="motivo" id="motivo" rows="3" class="form-control shadow-sm">{{ old('motivo', $atraso->motivo) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('atrasos.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-sm btn-primary">Atualizar Atraso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
