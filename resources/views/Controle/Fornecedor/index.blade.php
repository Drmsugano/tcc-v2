@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><i class="bi bi-truck"></i>Módulo de fornecedores</h1>
        <p class="text-muted">Gerencie facilmente os fornecedores da empresa <strong>{{ $usuarioView['EMPRESA'] }}</strong>
        </p>
    </div>

    <div class="mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bx bx-user-plus"></i> Novo Fornecedor
            </div>
            <div class="card-body p-4">
                <form id="formNovoFornecedor" autocomplete="off">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="cnpjFornecedor" class="form-label fw-semibold">CNPJ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-barcode"></i></span>
                                <input type="text" class="form-control" id="cnpjFornecedor" name="cnpjFornecedor"
                                    placeholder="00.000.000/0000-00" maxlength="18" oninput="formatarCNPJ(this)" required>
                                <button class="btn btn-outline-primary" type="button"
                                    onclick="procurarCNPJ(document.getElementById('cnpjFornecedor').value)">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col">
                            <label for="nomeFornecedor" class="form-label fw-semibold">Nome / Razão Social</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-text"></i></span>
                                <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor"
                                    placeholder="Ex: Empresa XYZ Ltda" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <label for="tipoFornecedor" class="form-label fw-semibold">Tipo de Fornecedor</label>
                            <select class="form-select" id="tipoFornecedor" name="tipoFornecedor" required>
                                <option value="" disabled selected>Selecione...</option>
                                @foreach ($tiposFornecedores as $tipo)
                                    <option value="{{ $tipo->ID }}">{{ $tipo->NOME }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="CEP" class="form-label fw-semibold">CEP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-map-pin"></i></span>
                                <input type="text" class="form-control" id="CEP" name="CEP" placeholder="00000-000"
                                    maxlength="9" oninput="formatarCEP(this)" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="enderecoFornecedor" class="form-label fw-semibold">Endereço</label>
                            <input type="text" class="form-control" id="enderecoFornecedor" name="enderecoFornecedor"
                                placeholder="Rua, número, complemento" required>
                        </div>
                        <div class="col-md-2">
                            <label for="estadoFornecedor" class="form-label fw-semibold">Estado</label>
                            <input type="text" class="form-control text-uppercase" id="estadoFornecedor"
                                name="estadoFornecedor" maxlength="2" placeholder="UF" required>
                        </div>
                        <div class="col-md-2">
                            <label for="cidadeFornecedor" class="form-label fw-semibold">Cidade</label>
                            <input type="text" class="form-control" id="cidadeFornecedor" name="cidadeFornecedor"
                                placeholder="Cidade" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="telefoneFornecedor" class="form-label fw-semibold">Telefone de Contato</label>
                            <input type="text" class="form-control" id="telefoneFornecedor" name="telefoneFornecedor"
                                placeholder="(00) 0000-0000" maxlength="14" oninput="formatarTelefone(this)" required>
                        </div>
                        <div class="col">
                            <label for="responsavelFornecedor" class="form-label fw-semibold">Nome do Responsável</label>
                            <input type="text" class="form-control" id="responsavelFornecedor" name="nomeResponsavel"
                                placeholder="Nome do Responsável" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="descricaoFornecedor" class="form-label fw-semibold">Descrição / Observações</label>
                        <textarea class="form-control" id="descricaoFornecedor" name="descricaoFornecedor" rows="3"
                            placeholder="Ex: Fornecedor de EPI com entregas semanais..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bx bx-eraser me-1"></i> Limpar
                        </button>
                        <button type="submit" class="btn btn-success" id="btnSalvarFornecedor"
                            onclick="enviarFormulario(event)">
                            <i class="bx bx-save me-1"></i> Salvar Fornecedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Lista de Fornecedores --}}
    <div>
        <h5 class="fw-bold text-primary mb-3">
            <i class="bx bx-filter-alt me-2"></i>Filtro de Fornecedores
        </h5>
        <form id="pesquisaFornecedor">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Nome</label>
                    <input type="text" id="nomeFornecedor" name="nomeFornecedor" class="form-control form-control-lg border-primary"
                        placeholder="Pesquisar nome...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Status</label>
                    <select name="statusFornecedor" id="statusFornecedor" class="form-select form-select-lg border-primary">
                        <option value="">Selecionar Status</option>
                        <option value="ATIVO">Ativo</option>
                        <option value="INATIVO">Inativo</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Tipo</label>
                    <select name="tipoFornecedor" id="tipoFornecedor" class="form-select form-select-lg border-primary">
                        <option value="">Selecionar Tipo</option>
                        @foreach ($tiposFornecedores as $tipo)
                            <option value="{{ $tipo->ID }}">{{ $tipo->TIPO }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-end gap-3 mt-4">
            <button class="btn btn-lg btn-outline-primary px-4" onclick="aplicarFiltros(event)">
                <i class="bx bx-search me-2"></i>Pesquisar
            </button>
            <button class="btn btn-lg btn-outline-danger px-4" type="button" onclick="limparFiltros()">
                <i class="bx bx-x me-2"></i>Limpar
            </button>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary"><i class="bx bx-list-ul"></i> Lista de Fornecedores</h3>
        </div>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr class="text">
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Estado</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="corpoTabelaFornecedor"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-center">
                            <div id="paginacaoFornecedor"></div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/Controle/Fornecedor/index.js') }}"></script>
    <script src="{{ asset('js/Controle/Fornecedor/tabela.js') }}"></script>
    <script src="{{ asset('js/Controle/Fornecedor/formulario.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection