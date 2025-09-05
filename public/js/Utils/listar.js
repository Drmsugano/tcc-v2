class TabelaDinamica {
    constructor({
        urlBase,
        corpoId,
        paginacaoId,
        colunas = [],
        acoes = [],
        itensPorPagina = 10,
    }) {
        this.urlBase = urlBase;
        this.corpo = document.getElementById(corpoId);
        this.paginacao = document.getElementById(paginacaoId);
        this.colunas = colunas;
        this.acoes = acoes;
        this.itensPorPagina = itensPorPagina;
        this.paginaAtual = 1;
        this.dados = [];
    }
    async carregarDados() {
        try {
            const response = await fetch(`${this.urlBase}/getDados`);
            const json = await response.json();
            this.dados = json || [];
            this.paginaAtual = 1;
            if (!this.dados.length) {
                this.corpo.innerHTML = `<tr><td colspan="${
                    this.colunas.length + 1
                }" class="text-center text-muted">Nenhum dado encontrado.</td></tr>`;
                this.paginacao.innerHTML = "";
                return;
            }
            this.renderizarTabela();
            this.renderizarPaginacao();
        } catch (erro) {
            console.error("Erro ao carregar dados:", erro);
            this.corpo.innerHTML = `<tr><td colspan="${
                this.colunas.length + 1
            }" class="text-danger text-center">Erro ao carregar dados.</td></tr>`;
        }
    }

    renderizarTabela() {
        this.corpo.innerHTML = "";
        const inicio = (this.paginaAtual - 1) * this.itensPorPagina;
        const fim = inicio + this.itensPorPagina;
        const dadosPagina = this.dados.slice(inicio, fim);
        dadosPagina.forEach((item) => {
            const linha = document.createElement("tr");
            this.colunas.forEach((coluna) => {
                const celula = document.createElement("td");
                celula.className = "align-middle";
                const valor = item[coluna];
                celula.textContent = valor;
                linha.appendChild(celula);
            });
            if (this.acoes.length) {
                const celulaAcoes = document.createElement("td");
                celulaAcoes.className = "align-middle text-end";
                this.acoes.forEach((acao) => {
                    const botao = document.createElement("button");
                    botao.className =
                        "btn btn-sm me-1 btn-outline-" +
                        (acao.cor ?? "primary");
                    botao.title =
                        acao.nome.charAt(0).toUpperCase() + acao.nome.slice(1);
                    botao.innerHTML = `<i class="bx ${acao.icone}"></i>`;
                    botao.addEventListener("click", () =>
                        acao.callback(item.id, item)
                    );
                    celulaAcoes.appendChild(botao);
                });
                linha.appendChild(celulaAcoes);
            }
            this.corpo.appendChild(linha);
        });
    }
    renderizarPaginacao() {
        this.paginacao.innerHTML = "";
        const totalPaginas = Math.ceil(this.dados.length / this.itensPorPagina);
        for (let i = 1; i <= totalPaginas; i++) {
            const botao = document.createElement("button");
            botao.textContent = i;
            botao.className = "btn btn-sm btn-outline-primary me-1";
            if (i === this.paginaAtual) botao.classList.add("active");
            botao.addEventListener("click", () => {
                this.paginaAtual = i;
                this.renderizarTabela();
                this.renderizarPaginacao();
            });
            this.paginacao.appendChild(botao);
        }
    }
}
