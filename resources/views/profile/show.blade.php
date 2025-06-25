@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-1">
        <div class="card-body p-4">

            <div class="row mb-4">
                <div class="col text-center">
                    <h1 class="fw-bold text-dark position-relative d-inline-block mb-3">
                        Meu Perfil
                        <span class="title-underline"></span>
                    </h1>
                    <p class="text-muted fs-5">Visualize e atualize suas informações pessoais abaixo.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4 shadow-sm border-1">
                <div class="card-header">Informações Básicas</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nome</label>
                        <input type="text" id="name" value="{{ $user->name }}" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">E-mail</label>
                        <input type="email" id="email" value="{{ $user->email }}" class="form-control" disabled>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-1">
                <div class="card-header">Alterar Senha</div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Senha Atual</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">Nova Senha</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-semibold">Confirme a Nova Senha</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning">Alterar Senha</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
