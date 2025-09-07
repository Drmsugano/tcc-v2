<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="/">
            <span class="fw-bold">
                {{ $usuarioView['EMPRESA'] }}
            </span>
        </a>

        {{-- Botão mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuERP">
            <i class='bx bx-menu'></i>
        </button>

        {{-- Links --}}
        <div class="collapse navbar-collapse" id="menuERP">
            <ul class="navbar-nav">
                    @if (in_array('ADMIN', $usuarioView['PERMISSOES'] ?? []))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.index') }}">
                            <i class='bx bx-cog'></i>
                            Administração
                        </a>
                    </li>
                @endif
                      @if (in_array('ADMIN', $usuarioView['PERMISSOES'] ?? []) || in_array('FINANCEIRO', $usuarioView['PERMISSOES'] ?? []))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <i class='bx bx-wallet'></i>
                            Financeiro
                        </a>
                    </li>
                @endif
                @if (in_array('ADMIN', $usuarioView['PERMISSOES'] ?? []) || in_array('CONTROLE', $usuarioView['PERMISSOES'] ?? []))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <i class='bx bx-group'></i>
                            Controle
                        </a>
                    </li>

                @endif
            </ul>
            {{-- Usuário --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="#">
                        <i class='bx bx-bell fs-5'></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="perfilDropdown"
                        role="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Usuário" alt="Avatar" class="rounded-circle me-2"
                            width="32" height="32">
                        <span>{{ $usuarioView['USUARIO'] }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="perfilDropdown">
                        <li><a class="dropdown-item" href="#"><i class='bx bx-user me-2'></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class='bx bx-cog me-2'></i>Configurações</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="{{ route('auth.logout') }}"><i class='bx bx-log-out me-2'></i>Sair</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>