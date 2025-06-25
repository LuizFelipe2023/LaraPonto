@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">

@section('content')
<div class="container-md mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-2">
                <div class="card-header text-center rounded-top">
                    <h1 class="fw-bold mb-0">Login</h1>
                    <small class="d-block mt-1">Informe suas credenciais para acessar o sistema</small>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
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

                    <form action="{{ route('login') }}" method="POST" id="formLogin">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="fw-semibold text-dark">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control shadow-sm" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="fw-semibold text-dark">Senha</label>
                            <input type="password" name="password" id="password" class="form-control shadow-sm" required>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
