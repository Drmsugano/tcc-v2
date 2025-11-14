@extends('Documentos.Obras.layout')
@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-folder2-open"></i> Documentação da Obra
            </h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpload">
                <i class="bi bi-upload"></i> Enviar Documento
            </button>
        </div>
        <!-- Tabela -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tabelaDocumentos">
                        <thead class="table-primary">
                            <tr>
                                <th>Obra</th>
                                <th>Descricao</th>
                                <th>Arquivo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaBody">
                            <tr>
                                <td colspan="3" class="text-center text-muted">Carregando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination justify-content-center" id="paginacaoDocObra"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="uploadForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-upload"></i> Enviar Documento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="TIPO_DOCUMENTO_ID" class="form-select" required>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->ID }}">{{ $tipo->NOME }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Arquivo</label>
                        <input type="file" name="arquivo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="DESCRICAO" class="form-control" rows="2" placeholder="" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Documentos/Obras/index.js') }}"></script>
@endsection