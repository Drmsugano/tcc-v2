<div class="sidebar close">
    <div class="logo-details">
        <i><a href="/Agendamento"><img src="/img/Caixa.png" width="48px" height="48px"></a></i>
        <span class="logo_name"><i><img src="/img/CamainboxWhiteSCR.png" height="35px"></i></span>
    </div>
    <ul class="nav-links">
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i><img src="/img/expedition.png" width="30px" style="filter:invert(100%)"></i>
                    <span class="link_name">Expedição</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <div class="iocn-link">
                        <a href="/Agendamento">Agendamentos</a> 
                        <i class='bx bxs-chevron-down arrow-sub'></i>
                    </div>
                    <ul class="sub-sub-menu"> 
                        <li><a href='/Agendamento/create'>Cadastrar</a></li>
                        <li><a href="/Agendamento">Listar</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="/Agendamento">Reservas</a> 
                        <i class='bx bxs-chevron-down arrow-sub'></i>
                    </div>
                    <ul class="sub-sub-menu">
                        <li><a href='#'>Menu-1</a></li>
                        <li><a href="#">Menu-2</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="/img/Caixa.png" alt="profileImg">
                </div>
                <div class="name-job">
                    <div class='profile_name'>{{JWTAuth::parseToken()->getPayload()->get('USUARIO')}}</div>
                    <div class='job'>
                        {{JWTAuth::parseToken()->getPayload()->get('PERFIL')}}
                    </div>
                </div>
                <div class="ps-3 ms-4"></div>
                <div class="vr" style="height:auto; color: white;"></div>
                <i class='bx bx-log-out pe-3'></i>
            </div>
        </li>
    </ul>
</div>