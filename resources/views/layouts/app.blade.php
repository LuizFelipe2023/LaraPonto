<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Minha Aplicação')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top navbar-scroll bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                LaraPonto
            </a>

            <button class="navbar-toggler ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSistema"
                aria-controls="navbarSistema" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon d-flex justify-content-start align-items-center"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSistema">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    @auth
                        @if(in_array(Auth::user()->tipo_usuario, [1, 2]))
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->routeIs(
                                'users.*',
                                'setores.*',
                                'funcionarios.*',
                                'pontos.*',
                                'faltas.*',
                                'atrasos.*'
                            ) ? 'active' : '' }}" href="#" id="gestaoDropdown" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Gestão
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gestaoDropdown">
                                                @if(Auth::user()->tipo_usuario == 1)
                                                    <li>
                                                        <h6 class="dropdown-header">Administração</h6>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                                            href="{{ route('users.painel') }}">
                                                            <i class="bi bi-people-fill me-2"></i>Usuários
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item {{ request()->routeIs('setores.*') ? 'active' : '' }}"
                                                            href="{{ route('setores.index') }}">
                                                            <i class="bi bi-diagram-3-fill me-2"></i>Setores
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                @endif

                                                <li>
                                                    <h6 class="dropdown-header">Operacional</h6>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->routeIs('funcionarios.*') ? 'active' : '' }}"
                                                        href="{{ route('funcionarios.index') }}">
                                                        <i class="bi bi-person-badge-fill me-2"></i>Funcionários
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->routeIs('pontos.*') ? 'active' : '' }}"
                                                        href="{{ route('pontos.index') }}">
                                                        <i class="bi bi-clock-fill me-2"></i>Pontos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->routeIs('faltas.*') ? 'active' : '' }}"
                                                        href="{{ route('faltas.index') }}">
                                                        <i class="bi bi-calendar-x-fill me-2"></i>Faltas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ request()->routeIs('atrasos.*') ? 'active' : '' }}"
                                                        href="{{ route('atrasos.index') }}">
                                                        <i class="bi bi-clock-history me-2"></i>Atrasos
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('pontos.funcionario', 'profile') ? 'active' : '' }}"
                                href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('pontos.funcionario') ? 'active' : '' }}"
                                        href="{{ route('pontos.funcionario', Auth::user()->funcionario->id) }}">
                                        <i class="bi bi-clock-history me-2"></i>Meus Pontos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('profile') ? 'active' : '' }}"
                                        href="{{ route('profile') }}">
                                        <i class="bi bi-person-circle me-2"></i>Perfil
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Sair
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endauth

                </ul>

                @auth
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
    </nav>


    <div class="content-wrapper">
        <div class="container mt-5 pt-4 pb-4">
            @yield('content')
        </div>
    </div>

    <footer class="bg-white shadow-sm border-top">
        <div class="container py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between">

                <div class="mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark">LaraPonto</h5>
                    <p class="text-secondary">Sistema de Controle de Ponto e Gestão de Usuários.</p>
                </div>

                <div>
                    <h5 class="fw-bold text-dark">Contato</h5>
                    <ul class="list-unstyled text-secondary">
                        <li>Email: suporte@laraponto.com</li>
                        <li>Telefone: (00) 1234-5678</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="bg-light text-center py-3 border-top">
            <small class="text-muted">© {{ date('Y') }} LaraPonto. Todos os direitos reservados.</small>
        </div>
    </footer>


</body>

</html>