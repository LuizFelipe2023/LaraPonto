@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
<div class="container-md mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg rounded-2">
                <div class="card-header text-center rounded-top">
                    <h1 class="fw-bold mb-0">Registrar Saída</h1>
                    <small class="d-block mt-1">Confirme o horário de saída</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pontos.storeSaida', $pontoAberto->id) }}" method="POST" id="saidaPonto">
                        @csrf
                        <div class="row g-4">

                            <div class="col-md-12">
                                <label class="fw-semibold text-dark">Funcionário</label>
                                <input type="text" class="form-control shadow-sm" 
                                       value="{{ $funcionario->usuario->name ?? 'N/A' }} - {{ $funcionario->cargo }}" 
                                       disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-semibold text-dark">Data</label>
                                <input type="date" class="form-control shadow-sm" 
                                       value="{{ $pontoAberto->data }}" disabled>
                            </div>

                            <div class="col-md-3">
                                <label class="fw-semibold text-dark">Hora Entrada</label>
                                <input type="time" class="form-control shadow-sm" 
                                       value="{{ $pontoAberto->hora_entrada }}" disabled>
                            </div>

                            <div class="col-md-3">
                                <label class="fw-semibold text-dark">Hora Saída</label>
                                <input type="time" class="form-control shadow-sm" 
                                       value="{{ now()->format('H:i') }}" disabled>
                                <input type="hidden" name="hora_saida" value="{{ now()->format('H:i:s') }}">
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('pontos.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Registrar Saída</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
