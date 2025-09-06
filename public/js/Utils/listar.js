class TabelaDinamica {
    constructor({
        urlBase,
        corpoId,
        paginacaoId,
        colunas = [],
        acoes = [],
        itensPorPagina = 10,
        cacheMax = 50,
    }) {
        this.urlBase = urlBase;
        this.corpo = document.getElementById(corpoId);
        this.paginacao = document.getElementById(paginacaoId);
        this.colunas = colunas;
        this.acoes = acoes;
        this.itensPorPagina = itensPorPagina;
        this.paginaAtual = 1;
        this.dados = [];
        this.meta = {};
        this.links = [];
        this.cache = new Map();
        this.cacheMax = cacheMax;
        this.filtrosAtuais = {};
    }

    async carregarDados(pagina = 1, filtros = {}) {
        const chaveCache = JSON.stringify({ pagina, filtros });
        this.filtrosAtuais = filtros;

        // Recupera do cache
        if (this.cache.has(chaveCache)) {
            const cached = this.cache.get(chaveCache);
            this.dados = cached.data;
            this.meta = cached.meta;
            this.links = cached.links;
            this.paginaAtual = pagina;
            this.renderizarTabela();
            this.renderizarPaginacao();
            return;
        }

        // Mostrar loader apenas se não houver
        if (!Swal.isVisible()) {
            Swal.fire({
                title: "Carregando...",
                text: "Coletando dados.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });
        }

        try {
            const params = new URLSearchParams({
                page: pagina,
                perPage: this.itensPorPagina,
                ...filtros,
            });
            const response = await fetch(`${this.urlBase}/getDados?${params}`);
            const json = await response.json();

            this.dados = json.data || [];
            this.meta = {
                current_page: json.current_page,
                last_page: json.last_page,
                per_page: json.per_page,
                total: json.total,
            };
            this.links = json.links || [];
            this.paginaAtual = this.meta.current_page;

            // Salvar no cache
            this._addCache(chaveCache, { data: this.dados, meta: this.meta, links: this.links });

            this.renderizarTabela();
            this.renderizarPaginacao();
        } catch (erro) {
            console.error("Erro ao carregar dados:", erro);
            this.corpo.innerHTML = `<tr><td colspan="${this.colunas.length + 1}" class="text-danger text-center">Erro ao carregar dados.</td></tr>`;
        } finally {
            Swal.isVisible() && Swal.close();
        }
    }

    _addCache(chave, valor) {
        if (this.cache.size >= this.cacheMax) {
            const firstKey = this.cache.keys().next().value;
            this.cache.delete(firstKey);
        }
        this.cache.set(chave, valor);
    }

    renderizarTabela() {
        this.corpo.innerHTML = "";
        this.dados.forEach((item) => {
            const linha = document.createElement("tr");
            linha.id = `${item.tabela}-${item.ID}`;

            this.colunas.forEach((coluna) => {
                const celula = document.createElement("td");
                celula.className = "align-middle";

                // Status como badge
                if (coluna.toLowerCase().includes("status")) {
                    const span = document.createElement("span");
                    const cores = { "Ativa": "success", "Concluída": "primary", "Em Andamento": "warning" };
                    const cor = cores[item[coluna]] ?? "secondary";
                    span.className = `badge bg-${cor}`;
                    span.textContent = item[coluna];
                    celula.appendChild(span);
                } else {
                    celula.textContent = this._formatarValor(coluna, item[coluna]);
                }

                linha.appendChild(celula);
            });

            if (this.acoes.length) {
                const celulaAcoes = document.createElement("td");
                this.acoes.forEach((acao) => {
                    const botao = document.createElement("button");
                    botao.id = `${item.tabela}-${item.ID}`;
                    botao.className =
                        "btn btn-sm me-1 " +
                        (acao.cor ? `btn-outline-${acao.cor}` : "btn-outline-primary");
                    botao.title = acao.nome.charAt(0).toUpperCase() + acao.nome.slice(1);
                    botao.innerHTML = acao.icone
                        ? `<i class="bx ${acao.icone} me-1"></i>${acao.texto || ""}`
                        : acao.texto || "";
                    botao.addEventListener("click", () => acao.callback(item.ID, item));
                    celulaAcoes.appendChild(botao);
                });
                linha.appendChild(celulaAcoes);
            }

            this.corpo.appendChild(linha);
        });
    }

    renderizarPaginacao() {
        this.paginacao.innerHTML = "";
        if (!this.meta.last_page || this.meta.last_page <= 1) return;

        const total = this.meta.last_page;
        const current = this.paginaAtual;

        // Botão anterior
        this._criarBotao("«", current > 1, () => this.carregarDados(current - 1));

        // Primeira página
        this._criarBotaoPagina(1, current);

        let start = Math.max(2, current - 2);
        let end = Math.min(total - 1, current + 2);

        if (start > 2) this._adicionarEllipsis();
        for (let i = start; i <= end; i++) this._criarBotaoPagina(i, current);
        if (end < total - 1) this._adicionarEllipsis();

        if (total > 1) this._criarBotaoPagina(total, current);

        // Botão próximo
        this._criarBotao("»", current < total, () => this.carregarDados(current + 1));
    }

    _criarBotaoPagina(pagina, atual) {
        const ativo = pagina === atual;
        this._criarBotao(pagina, true, () => this.carregarDados(pagina), ativo);
    }

    _criarBotao(texto, habilitado, callback, ativo = false) {
        const btn = document.createElement("button");
        btn.textContent = texto;
        btn.className = "btn btn-sm me-1 " + (ativo ? "btn-primary text-white" : "btn-outline-primary");
        btn.disabled = !habilitado;
        btn.addEventListener("click", callback);
        this.paginacao.appendChild(btn);
    }

    _adicionarEllipsis() {
        const span = document.createElement("span");
        span.textContent = "...";
        span.className = "me-1";
        this.paginacao.appendChild(span);
    }

    _formatarValor(coluna, valor) {
        if (!valor) return "";
        if (coluna.toLowerCase().includes("data")) {
            const d = new Date(valor);
            if (!isNaN(d)) return d.toLocaleDateString();
        }
        return valor;
    }
}
