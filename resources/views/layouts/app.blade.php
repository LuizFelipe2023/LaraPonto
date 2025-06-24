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
            <a class="navbar-brand fw-bold" href="{{ route('users.painel') }}">
                LaraPonto
            </a>

            <button class="navbar-toggler ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSistema"
                aria-controls="navbarSistema" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon d-flex justify-content-start align-items-center"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSistema">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                            href="{{ route('users.painel') }}">
                            Usuários
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('funcionarios.*') ? 'active' : '' }}"
                            href="{{ route('funcionarios.index') }}">
                            Funcionários
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('setores.*') ? 'active' : '' }}"
                            href="{{ route('setores.index') }}">
                            Setores
                        </a>
                    </li>

                </ul>
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
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark">LaraPonto</h5>
                    <p class="text-secondary">Sistema de Controle de Ponto e Gestão de Usuários.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark">Navegação</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('users.painel') }}"
                                class="text-decoration-none text-secondary">Usuários</a></li>
                        <li><a href="#" class="text-decoration-none text-secondary">Relatórios</a></li>
                        <li><a href="#" class="text-decoration-none text-secondary">Configurações</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
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