<div class="sidebar close">
    <div class="logo-details">
        <i><a href="/Home">
                <img src="/img/logo.png" style="filter:invert(100%)" height="45px">
            </a>
        </i>
        <span class="logo_name">
            <i>
                Rosfield SST
            </i>
        </span>
    </div>
    <ul class="nav-links">
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i><img src="/img/expedition.png" width="30px" style="filter:invert(100%)"></i>
                    <span class="link_name">Tecnicos de Segurança</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <div class="iocn-link">
                        <a href="/TecnicoSec">
                            Tecnicos de Segurança
                        </a>
                        <i class='bx bxs-chevron-down arrow-sub'></i>
                    </div>
                    <ul class="sub-sub-menu">
                        <li>
                            <a href='/TecnicoSec/create'>Cadastrar</a>
                        </li>
                        <li>
                            <a href="/TecnicoSec">Listar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="/Empresa">
                    <i><img src="/img/empresa.png" width="30px" style="filter:invert(100%)"></i>
                    <span class="link_name">Empresas</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <div class="iocn-link">
                        <a href="/Empresa">
                            Empresas
                        </a>
                        <i class='bx bxs-chevron-down arrow-sub'></i>
                    </div>
                    <ul class="sub-sub-menu">
                        <li>
                            <a href='/Empresa/create'>Cadastrar</a>
                        </li>
                        <li>
                            <a href="/Empresa">Listar</a>
                        </li>
                    </ul>
                </li>
            </ul>
            @if (session('empresaId') != null)
                <li>
                    <div class="iocn-link">
                        <a href="/Funcionario">
                            <i><img src="/img/funcionario.png" width="30px" style="filter:invert(100%)"></i>
                            <span class="link_name">Funcionários</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li>
                            <a href="/Funcionario/create">Cadastrar</a>
                        </li>
                        <li>
                            <a href="/Funcionario">Listar</a>
                        </li>
                    </ul>
                </li>
            @endif
    </ul>
    <li>
        <div class="profile-details">
            <div class="profile-content">
                <img src="/img/perfil/{{ $usuario->PERFIL }}.png" alt="profileImg" class="profile-img">
            </div>
            <div class="name-job">
                <div class='profile_name'>{{$usuario->NOME}}</div>
                <div class='job'>
                    {{$usuario->PERFIL}}
                </div>
            </div>
            <div class="ps-3 ms-4"></div>
            <div class="vr" style="height:auto; color: white;"></div>
            <i class='bx bx-log-out pe-3'></i>
        </div>
    </li>
    </ul>
</div>