@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">
                <i class="bi bi-person-badge"></i> Detalhes do Funcionário
            </h1>
            <p class="text-muted">
                Gerencie facilmente os funcionários da empresa
                <strong>{{ $usuarioView['EMPRESA'] }}</strong>
            </p>
        </div>

        <form id="form-update" class="mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bx bx-info-circle"></i> Dados do Funcionário
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <input type="hidden" name="id" id="id" value="{{ $funcionario->ID }}">
                        <div class="col-md-6">
                            <label for="nomeFuncionario" class="form-label">Nome do Funcionário</label>
                            <input type="text" class="form-control" id="nomeFuncionario" data-editavel="true" name="nomeFuncionario"
                                value="{{ $funcionario->NOME }}" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="cpfFuncionario" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpfFuncionario" name="cpfFuncionario" data-editavel="true"
                                value="{{ $funcionario->CPF }}" oninput="formatarCpf(this)" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="pis" class="form-label">PIS</label>
                            <input type="text" class="form-control" id="pis" name="pis" oninput="formatarPis(this)" value="{{ $funcionario->PIS }}"
                                required  data-editavel="true" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="dataAdmissao" class="form-label">Data de Admissão</label>
                            <input type="date" class="form-control" id="dataAdmissao" name="dataAdmissao"
                                value="{{ $funcionario->DATA_ADMISSAO }}" required  data-editavel="true" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="dataDemissao" class="form-label">Data de Demissão</label>
                            <input type="date" class="form-control" id="dataDemissao" name="dataDemissao"
                                value="{{ $funcionario->DATA_DEMISSAO }}">
                        </div>
                        <div class="col-md-6">
                            <label for="statusFuncionario" class="form-label">Status</label>
                            <select class="form-select" id="statusFuncionario" name="statusFuncionario" required>
                                <option value="">Selecione o Status</option>
                                <option value="0" {{ $funcionario->IS_DELETED == 0 ? 'selected' : '' }}>Ativo</option>
                                <option value="1" {{ $funcionario->IS_DELETED == 1 ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="funcaoFuncionario" class="form-label">Função</label>
                            <select class="form-select" id="funcaoFuncionario" name="funcaoFuncionario" data-editavel="true" required aria-readonly="true">
                                <option value="">Selecione a Função</option>
                                @foreach ($funcoes as $funcao)
                                    <option value="{{ $funcao->ID }}" {{ $funcionario->FUNCAO_ID == $funcao->ID ? 'selected' : '' }}>
                                        {{ $funcao->NOME }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3 me-3">
                        <button type="button" class="btn btn-outline-secondary" id="btnHabilitarEdicao" onclick="habilitarEdicao()">Habilitar
                            Edição</button>
                        <button type="button" class="btn btn-outline-secondary ms-2" id="btnCancelarEdicao" onclick="location.reload()">Cancelar
                            Edição</button>
                        <button type="button" class="btn btn-primary ms-2" id="btnSalvarAlteracoes" onclick="enviarFormulario(event)" disabled>Salvar
                            Alterações</button>
                    </div>  
            </div>
        </form>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-clock-history"></i> Documentos deste Funcionário
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p class="text-muted mb-3">
                    Clique abaixo para ver os documentos referentes a este funcionário:
                </p>
                <a href="#" class="btn btn-outline-primary mt-auto">
                    <i class="bi bi-folder2-open"></i> Ver Documentos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-success text-white">
                <i class="bi bi-shield-check"></i> EPIs deste Funcionário
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p class="text-muted mb-3">
                    Clique abaixo para ver os EPIs referentes a este funcionário:
                </p>
                <a href="#" class="btn btn-outline-primary mt-auto">
                    <i class="bi bi-folder2-open"></i> Ver EPIs
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-file-earmark-text"></i> NR's deste Funcionário
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p class="text-muted mb-3">
                    Clique abaixo para ver as NR's referentes a este funcionário:
                </p>
                <a href="#" class="btn btn-outline-primary mt-auto">
                    <i class="bi bi-folder2-open"></i> Ver NR's
                </a>
            </div>
        </div>
    </div>
    </div>
</div>
<script src="{{ asset('js/Controle/Funcionario/detalhes.js') }}"></script>
<script src="{{ asset('js/Controle/Funcionario/index.js') }}"></script>
<script src="{{ asset('js/Utils/listar.js') }}"></script>
<script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection