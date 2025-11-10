@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary"><i class="bi bi-truck"></i> Detalhes do Fornecedor</h1>
            <p class="text-muted">Gerencie facilmente os fornecedores da empresa
                <strong>{{ $usuarioView['EMPRESA'] }}</strong>
            </p>
        </div>

        <form id="form-update">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bx bx-info-circle"></i> Detalhes do Fornecedor
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                     <div class="col-md-4">
                        <input type="text" name="id" value="{{ $fornecedor->ID }}" hidden>
                            <label for="cnpjFornecedor" class="form-label fw-semibold">CNPJ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-barcode"></i></span>
                                <input type="text" class="form-control" id="cnpjFornecedor" name="cnpjFornecedor"
                                    placeholder="00.000.000/0000-00" maxlength="18" oninput="formatarCNPJ(this)" value="{{ $fornecedor->CNPJ }}" data-editavel="true" readonly>
                                <button class="btn btn-outline-primary" type="button"
                                    onclick="procurarCNPJ(document.getElementById('cnpjFornecedor').value)">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <label for="nomeFornecedor" class="form-label fw-semibold">Nome / Razão Social</label>
                            <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor"
                                value="{{ $fornecedor->NOME_FORNECEDOR }}" data-editavel="true" readonly>
                        </div>
                        <div class="col">
                            <label for="statusFornecedor" class="form-label fw-semibold">Status</label>
                           <select name="statusFornecedor" id="statusFornecedor" class="form-select" data-editavel="true">
                               <option value="Ativo" {{ $fornecedor->IS_DELETED == 0 ? 'selected' : '' }}>Ativo</option>
                               <option value="Inativo" {{ $fornecedor->IS_DELETED == 1 ? 'selected' : '' }}>Inativo</option>
                           </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="tipoFornecedor" class="form-label fw-semibold">Tipo de Fornecedor</label>
                            <select name="tipoFornecedor" id="tipoFornecedor" class="form-select" data-editavel="true">
                                @foreach($tiposFornecedores as $tipo)
                                    <option value="{{ $tipo->ID }}" {{ $tipo->ID == $fornecedor->TIPO_FORNECEDOR_ID ? 'selected' : '' }}>
                                        {{ $tipo->TIPO }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomeResponsavel" class="form-label fw-semibold">Nome do Responsável</label>
                            <input type="text" class="form-control" id="nomeResponsavel" name="nomeResponsavel"
                                value="{{ $fornecedor->VENDEDOR }}" data-editavel="true" readonly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="telefoneFornecedor" class="form-label fw-semibold">Telefone</label>
                            <input type="text" class="form-control" id="telefoneFornecedor" name="telefoneFornecedor"
                                value="{{ $fornecedor->TELEFONE }}" data-editavel="true" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="estadoFornecedor" class="form-label fw-semibold">Estado</label>
                            <input type="text" class="form-control" id="estadoFornecedor" name="estadoFornecedor"
                                value="{{ $fornecedor->ESTADO }}" data-editavel="true" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="cidadeFornecedor" class="form-label fw-semibold">Cidade</label>
                            <input type="text" class="form-control" id="cidadeFornecedor" name="cidadeFornecedor"
                                value="{{ $fornecedor->CIDADE }}" data-editavel="true" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="cepFornecedor" class="form-label fw-semibold">CEP</label>
                            <input type="text" class="form-control" id="CEP" name="cepFornecedor"
                                value="{{ $fornecedor->CEP }}" data-editavel="true" readonly>
                        </div>
                        <div class="col my-4">
                            <label for="enderecoFornecedor" class="form-label fw-semibold">Endereço</label>
                            <input type="text" class="form-control" id="enderecoFornecedor" name="enderecoFornecedor"
                                placeholder="Rua, número, complemento" value="{{ $fornecedor->ENDERECO }}" data-editavel="true" readonly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="observacaoFornecedor" class="form-label fw-semibold">Observação</label>
                            <textarea class="form-control" id="observacaoFornecedor" data-editavel="true"
                                name="descricaoFornecedor" rows="3" readonly>{{ $fornecedor->OBSERVACAO }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" id="btnHabilitarEdicao" onclick="habilitarEdicao()">Habilitar
                            Edição</button>
                        <button type="button" class="btn btn-outline-secondary ms-2" id="btnCancelarEdicao" onclick="location.reload()">Cancelar
                            Edição</button>
                        <button type="button" class="btn btn-primary ms-2" id="btnSalvarAlteracoes" onclick="enviarFormulario(event)" disabled>Salvar
                            Alterações</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/Controle/Fornecedor/detalhes.js') }}"></script>
    <script src="{{ asset('js/Controle/Fornecedor/index.js') }}"></script>
     <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection