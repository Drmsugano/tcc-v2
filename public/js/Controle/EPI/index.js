document.addEventListener("DOMContentLoaded", () => {
    window.tabelaEPI = new TabelaDinamica({
        urlBase: "/Controle/EPI",
        corpoId: "corpoTabelaEPI",
        paginacaoId: "paginacaoEPI",
        colunas: ["CA", "NOME_EPI", "DESCRICAO", "QUANTIDADE_ESTOQUE"],
        acoes: [
            {
                nome: "Ver",
                texto: "Ver Detalhes",
                cor: "warning",
                callback: (id) => selecionar(id),
            },
        ],
        itensPorPagina: 10,
    });
    tabelaEPI.carregarDados();
    document.getElementById("pesquisaEpi").addEventListener("submit", pesquisarEpi);
    function debounce(fn, wait = 300) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(context, args), wait);
        };
    }
    const filtroInput = document.getElementById("filtroEpi");
    if (filtroInput) {
        const debouncedCarregar = debounce(() => {
            const valor = filtroInput.value.trim();
            const filtros = {};
            if (valor) filtros.filtroEpi = valor;
            tabelaEPI.carregarDados(1, filtros, false);
        }, 400);
        filtroInput.addEventListener("input", debouncedCarregar);
    }
});
function selecionar(id) {
    window.location.href = `/Controle/EPI/${id}`;
}
function pesquisarEpi(event) {
    event.preventDefault();
    const filtro = document.getElementById("filtroEpi").value;
    const filtros = {};
    if (filtro) {
        filtros.filtroEpi = filtro;
    }
    tabelaEPI.carregarDados(1, filtros, false);
}
