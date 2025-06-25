@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-5 text-center fw-bold">Bem-vindo(a), {{ auth()->user()->name }}!</h1>

    <div class="row g-4 justify-content-center">

        @php
            $user = auth()->user();
            $funcionarioId = $user->funcionario->id ?? null;
        @endphp

        @if ($user->tipo_usuario == 1)
            @php
                $cards = [
                    [
                        'route'=>'funcionarios.index',
                        'title'=>'Funcionários',
                        'subtitle'=>'Gerencie os colaboradores da empresa.',
                        'banner'=>'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'pontos.index',
                        'title'=>'Pontos',
                        'subtitle'=>'Controle os registros de entrada e saída.',
                        'banner'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'setores.index',
                        'title'=>'Setores',
                        'subtitle'=>'Organize os setores da organização.',
                        'banner'=>'https://images.unsplash.com/photo-1549924231-f129b911e442?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'users.painel',
                        'title'=>'Usuários',
                        'subtitle'=>'Gerencie acessos e permissões.',
                        'banner'=>'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'faltas.index',
                        'title'=>'Faltas',
                        'subtitle'=>'Gerencie as faltas registradas.',
                        'banner'=>'https://images.unsplash.com/photo-1588702547919-260734c2d032?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'atrasos.index',
                        'title'=>'Atrasos',
                        'subtitle'=>'Gerencie os atrasos registrados.',
                        'banner'=>'https://images.unsplash.com/photo-1598300052095-c1b9f656cab9?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'audits.index',
                        'title'=>'Auditorias',
                        'subtitle'=>'Visualize os registros de auditoria do sistema.',
                        'banner'=>'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=400&q=80'
                    ],
                ];
            @endphp

        @elseif ($user->tipo_usuario == 2)
            @php
                $cards = [
                    [
                        'route'=>'funcionarios.index',
                        'title'=>'Funcionários',
                        'subtitle'=>'Gerencie os colaboradores da empresa.',
                        'banner'=>'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'pontos.index',
                        'title'=>'Pontos',
                        'subtitle'=>'Controle os registros de entrada e saída.',
                        'banner'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'faltas.index',
                        'title'=>'Faltas',
                        'subtitle'=>'Gerencie as faltas registradas.',
                        'banner'=>'https://images.unsplash.com/photo-1588702547919-260734c2d032?auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'route'=>'atrasos.index',
                        'title'=>'Atrasos',
                        'subtitle'=>'Gerencie os atrasos registrados.',
                        'banner'=>'https://images.unsplash.com/photo-1598300052095-c1b9f656cab9?auto=format&fit=crop&w=400&q=80'
                    ],
                ];
            @endphp
        @endif

        @foreach($cards as $card)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm rounded-3 h-100">
                    <div style="
                        height: 140px;
                        background-image: url('{{ $card['banner'] }}');
                        background-size: cover;
                        background-position: center;
                        border-top-left-radius: .75rem;
                        border-top-right-radius: .75rem;"></div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-bold">{{ $card['title'] }}</h5>
                            <p class="card-text text-muted small">{{ $card['subtitle'] }}</p>
                        </div>
                        <a href="{{ route($card['route']) }}" class="btn btn-outline-primary mt-3 w-100">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        @if(in_array($user->tipo_usuario, [1,2,3]) && $funcionarioId)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm rounded-3 h-100">
                    <div style="
                        height: 140px;
                        background-image: url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=400&q=80');
                        background-size: cover;
                        background-position: center;
                        border-top-left-radius: .75rem;
                        border-top-right-radius: .75rem;"></div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-bold">Meus Pontos</h5>
                            <p class="card-text text-muted small">Visualize seus registros de ponto.</p>
                        </div>
                        <a href="{{ route('pontos.funcionario', $funcionarioId) }}" class="btn btn-outline-primary mt-3 w-100">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if(empty($cards) && !$funcionarioId)
            <p class="text-center text-muted">Sem permissões específicas para exibir.</p>
        @endif

    </div>
</div>
@endsection
