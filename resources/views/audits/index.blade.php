@extends('layouts.app')

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/auditsTable.js') }}"></script>

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-1">
        <div class="card-body p-4">

            <div class="row mb-4">
                <div class="col text-center">
                    <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                        Painel de Auditorias
                        <span class="title-underline"></span>
                    </h1>
                    <p class="text-muted fs-5">Visualize e filtre os registros de ações do sistema.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('audits.pdf') }}" method="GET" target="_blank" class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Data Início</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Data Fim</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Mês (opcional)</label>
                            <select name="mes" class="form-select">
                                <option value="">Selecione</option>
                                @foreach(range(1,12) as $m)
                                    <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-file-earmark-pdf me-2"></i>Gerar PDF
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white" id="auditsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Usuário</th>
                            <th>Ação</th>
                            <th>Detalhes</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($audits as $audit)
                            <tr>
                                <td>{{ $audit->user->name ?? '—' }}</td>
                                <td>{{ $audit->acao }}</td>
                                <td>{{ $audit->detalhes }}</td>
                                <td>{{ \Carbon\Carbon::parse($audit->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
