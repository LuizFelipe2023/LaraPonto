@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@section('content')
<div class="container-md mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg rounded-2">
                <div class="card-header text-center rounded-top">
                    <h1 class="fw-bold mb-0">Editar Usuário</h1>
                    <small class="d-block mt-1">Atualize os dados do usuário abaixo</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUser">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="fw-semibold text-dark">Nome</label>
                                <input type="text" name="name" id="name" class="form-control shadow-sm" 
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="fw-semibold text-dark">Email</label>
                                <input type="email" name="email" id="email" class="form-control shadow-sm" 
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="fw-semibold text-dark">Senha <small class="text-muted">(Deixe em branco para manter a senha atual)</small></label>
                                <input type="password" name="password" id="password" class="form-control shadow-sm" autocomplete="new-password">
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="fw-semibold text-dark">Confirmar Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-sm" autocomplete="new-password">
                            </div>

                            <div class="col-md-6">
                                <label for="tipo_usuario" class="fw-semibold text-dark">Tipo de Usuário</label>
                                <select name="tipo_usuario" id="tipo_usuario" class="form-select shadow-sm" required>
                                    <option value="">Selecione um Tipo</option>
                                    @foreach ($tipoUsuarios as $tipoUsuario)
                                        <option value="{{ $tipoUsuario->id }}" 
                                            {{ old('tipo_usuario', $user->tipo_usuario) == $tipoUsuario->id ? 'selected' : '' }}>
                                            {{ $tipoUsuario->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('users.painel') }}" class="btn btn-sm btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
