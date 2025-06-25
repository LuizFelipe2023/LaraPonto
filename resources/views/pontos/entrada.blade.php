@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
    <div class="container-md mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg rounded-2">
                    <div class="card-header text-center rounded-top">
                        <h1 class="fw-bold mb-0">Registrar Entrada</h1>
                        <small class="d-block mt-1">Confirme o horário de entrada</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pontos.storeEntrada', $funcionario->id) }}" method="POST" id="entradaPonto">
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-12">
                                    <label class="fw-semibold text-dark">Funcionário</label>
                                    <input type="text" class="form-control shadow-sm"
                                        value="{{ $funcionario->usuario->name ?? 'N/A' }} - {{ $funcionario->cargo }}"
                                        disabled>
                                    <input type="hidden" name="funcionario_id" value="{{ $funcionario->id }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold text-dark">Data</label>
                                    <input type="date" class="form-control shadow-sm" value="{{ now()->format('Y-m-d') }}"
                                        disabled>
                                    <input type="hidden" name="data" value="{{ now()->format('Y-m-d') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold text-dark">Hora Entrada</label>
                                    <input type="time" class="form-control shadow-sm" value="{{ now()->format('H:i') }}"
                                        disabled>
                                    <input type="hidden" name="hora_entrada" value="{{ now()->format('H:i:s') }}">
                                </div>

                            </div>

                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('pontos.index') }}" class="btn btn-sm btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-sm btn-primary">Registrar Entrada</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection