<?= $this->extend('layouts/totem') ?>

<?= $this->section('content') ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    /* Modificado para ocupar 100% da largura disponível com espaçamento seguro nas pontas */
    .produtos-area {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        width: 100%;
        padding: 0 15px;
    }

    /* Container dos filtros para melhor espaçamento */
    .categorias-wrapper {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Customização dos botões de categoria */
    .categoria-btn {
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    /* Container da Pré-visualização Lateral (Sidebar do Carrinho) */
    .carrinho-lateral {
        position: fixed;
        top: 0;
        right: -420px; /* Escondido por padrão */
        width: 400px;
        height: 100vh;
        background-color: #ffffff;
        box-shadow: -5px 0 30px rgba(0,0,0,0.1);
        z-index: 1060;
        transition: right 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
    }

    .carrinho-lateral.aberto {
        right: 0; /* Desliza para dentro da tela */
    }

    /* Fundo escuro quando o carrinho lateral abrir */
    .carrinho-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.4);
        z-index: 1050;
        display: none;
    }

    .carrinho-overlay.visivel {
        display: block;
    }

    .carrinho-lat-corpo {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .item-lat-card {
        border: 1px solid #eef2f5;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        background: #f8f9fa;
    }

    .produto-card {
        cursor: pointer;
        transition: .2s;
    }

    .produto-card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="produtos-area mt-4">

    <div class="mb-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="fw-bold m-0 text-dark">Faça seu Pedido</h1>
            <p class="text-muted m-0 mt-1">Escolha seus deliciosos produtos abaixo</p>
        </div>

        <button onclick="toggleCarrinhoLateral(true)" class="btn btn-dark position-relative py-2 px-4 rounded-3 fw-semibold shadow-sm">
            Ver Sacola 🛒
            <span id="badgeContador" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                0
            </span>
        </button>
    </div>

    <div class="mb-5 categorias-wrapper" id="categoriasContainer">
        <button class="btn btn-dark categoria-btn filtro" data-categoria="0">
            Todos
        </button>
    </div>

    <div class="row g-4 w-100 m-0 justify-content-start" id="produtosContainer">
        <div class="text-center text-muted py-5 w-100">Carregando produtos...</div>
    </div>

</div>

<div class="carrinho-overlay" id="carrinhoOverlay" onclick="toggleCarrinhoLateral(false)"></div>
<div class="carrinho-lateral" id="carrinhoLateral">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
        <h5 class="fw-bold m-0 text-dark">Sua Sacola</h5>
        <button class="btn-close" onclick="toggleCarrinhoLateral(false)"></button>
    </div>

    <div class="carrinho-lat-corpo" id="itensCarrinhoLateral">
        </div>

    <div class="p-3 border-top bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3 fs-5">
            <span class="text-secondary small fw-semibold">Subtotal:</span>
            <span id="totalCarrinhoLateral" class="fw-bold text-success fs-4">R$ 0,00</span>
        </div>
        <a href="<?= base_url('carrinho') ?>" class="btn btn-outline-dark w-100 mb-2 fw-semibold rounded-3 py-2">
            Ver Carrinho Completo
        </a>

    </div>
</div>

<?= view('componentes/modal_produto') ?>

<script>
// Inicializa o estado global puxando do LocalStorage
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
let produtoAtual = null;

/*====================================================
CARREGA CATEGORIAS E PRODUTOS DA API (cozinha_restaurante)
====================================================*/

function montarCardProduto(produto) {
    const imagem = produto.imagem
        ? ASSET_BASE + '/' + produto.imagem.replace(/^\//, '')
        : 'https://placehold.co/600x400?text=Produto';

    const badgeDestaque = produto.destaque == 1
        ? `<div class="badge bg-warning text-dark mb-2 position-absolute m-2" style="z-index: 2;">Destaque</div>`
        : '';

    return `
        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 produto-item p-2" data-categoria="${produto.categoria_id}">
            ${badgeDestaque}
            <div
                class="card produto-card h-100 shadow-sm"
                data-id="${produto.id}"
                data-nome="${escapeHtml(produto.nome)}"
                data-descricao="${escapeHtml(produto.descricao || '')}"
                data-preco="${produto.preco}"
                data-imagem="${imagem}">
                <img
                    src="${imagem}"
                    class="card-img-top"
                    alt="${escapeHtml(produto.nome)}"
                    loading="lazy"
                    onerror="this.src='https://placehold.co/600x400?text=Sem+Imagem';"
                    style="height:220px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="fw-bold">${escapeHtml(produto.nome)}</h5>
                    <p class="text-muted">${escapeHtml(produto.descricao || '')}</p>
                    <h4 class="text-success">R$ ${Number(produto.preco).toFixed(2).replace('.', ',')}</h4>
                </div>
            </div>
        </div>
    `;
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.innerText = texto;
    return div.innerHTML;
}

async function carregarCategorias() {
    try {
        const resposta = await fetch(API_BASE + '/categorias');
        const categorias = await resposta.json();

        const container = document.getElementById('categoriasContainer');

        categorias.forEach(categoria => {
            const btn = document.createElement('button');
            btn.className = 'btn btn-outline-dark categoria-btn filtro';
            btn.dataset.categoria = categoria.id;
            btn.innerText = categoria.nome;
            container.appendChild(btn);
        });

        ativarFiltrosCategoria();
    } catch (e) {
        console.error('Erro ao carregar categorias:', e);
    }
}

async function carregarProdutos() {
    const container = document.getElementById('produtosContainer');

    try {
        const resposta = await fetch(API_BASE + '/produtos');
        const produtos = await resposta.json();

        if (!produtos.length) {
            container.innerHTML = '<div class="text-center text-muted py-5 w-100">Nenhum produto disponível no momento.</div>';
            return;
        }

        container.innerHTML = produtos.map(montarCardProduto).join('');

        ativarCliquesProduto();
    } catch (e) {
        container.innerHTML = '<div class="text-center text-danger py-5 w-100">Não foi possível carregar os produtos. Tente novamente.</div>';
        console.error('Erro ao carregar produtos:', e);
    }
}

/*====================================================
EVENTOS (precisam ser reaplicados após montar o HTML via fetch)
====================================================*/

function ativarCliquesProduto() {
    document.querySelectorAll('.produto-card').forEach(card => {
        card.addEventListener('click', () => {
            produtoAtual = {
                id: card.dataset.id,
                nome: card.dataset.nome,
                descricao: card.dataset.descricao,
                preco: parseFloat(card.dataset.preco),
                imagem: card.dataset.imagem
            };

            document.getElementById('modalNome').innerText = produtoAtual.nome;
            document.getElementById('modalDescricao').innerText = produtoAtual.descricao;
            document.getElementById('modalPreco').innerText = "R$ " + produtoAtual.preco.toFixed(2);
            document.getElementById('modalImagem').src = produtoAtual.imagem;
            document.getElementById('quantidade').value = 1;
            document.getElementById('observacao').value = '';

            new bootstrap.Modal(document.getElementById('produtoModal')).show();
        });
    });
}

function ativarFiltrosCategoria() {
    document.querySelectorAll('.filtro').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filtro').forEach(b => b.classList.replace('btn-dark', 'btn-outline-dark'));
            btn.classList.replace('btn-outline-dark', 'btn-dark');

            let category = btn.dataset.categoria;
            document.querySelectorAll('.produto-item').forEach(item => {
                if (category == 0) {
                    item.style.display = 'block';
                } else {
                    item.style.display = item.dataset.categoria == category ? 'block' : 'none';
                }
            });
        });
    });
}

// Controla a abertura do painel lateral da sacola
function toggleCarrinhoLateral(abrir) {
    const sidebar = document.getElementById('carrinhoLateral');
    const overlay = document.getElementById('carrinhoOverlay');
    if (abrir) {
        sidebar.classList.add('aberto');
        overlay.classList.add('visivel');
    } else {
        sidebar.classList.remove('aberto');
        overlay.classList.remove('visivel');
    }
}

// Executa a adição do item configurado para dentro do array do carrinho
function adicionarCarrinho() {
    let quantidade = parseInt(document.getElementById('quantidade').value);
    let observacao = document.getElementById('observacao').value;

    let itemExistente = carrinho.find(item => item.id === produtoAtual.id && item.observacao === observacao);

    if (itemExistente) {
        itemExistente.quantidade += quantidade;
    } else {
        itemExistente = 
        carrinho.push({
            id: produtoAtual.id,
            nome: produtoAtual.nome,
            preco: produtoAtual.preco,
            quantidade: quantidade,
            observacao: observacao
        });
    }

    console.log("produto: ", )

    salvarCarrinho();

    bootstrap.Modal.getInstance(document.getElementById('produtoModal')).hide();

    toggleCarrinhoLateral(true);
}

// Atualiza o LocalStorage e dispara as atualizações em cascata na interface
function salvarCarrinho() {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarVisualLateral();
}

// Redesenha os elementos internos da gaveta lateral e do contador superior
function atualizarVisualLateral() {
    let div = document.getElementById('itensCarrinhoLateral');
    let badge = document.getElementById('badgeContador');
    div.innerHTML = '';

    let totalDinheiro = 0;
    let totalItensContagem = 0;

    if (carrinho.length === 0) {
        div.innerHTML = `<div class="text-center text-muted py-5">Sua sacola está vazia.</div>`;
        badge.classList.add('d-none');
        document.getElementById('totalCarrinhoLateral').innerHTML = "R$ 0,00";
        return;
    }

    carrinho.forEach((item, index) => {
        let subtotal = item.preco * item.quantidade;
        totalDinheiro += subtotal;
        totalItensContagem += item.quantidade;

        div.innerHTML += `
        <div class="item-lat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong class="d-block text-dark mb-1">${item.nome}</strong>
                    <small class="text-muted d-block">${item.quantidade}x R$ ${item.preco.toFixed(2)}</small>
                    ${item.observacao ? `<small class="text-danger d-block mt-1">Obs: "${item.observacao}"</small>` : ''}
                </div>
                <span class="fw-bold text-dark">R$ ${subtotal.toFixed(2)}</span>
            </div>
            <div class="text-end mt-2">
                <button class="btn btn-sm text-danger p-0 border-0 bg-transparent fw-semibold" onclick="removerLat(${index})" style="font-size: 0.85rem">
                    Remover
                </button>
            </div>
        </div>
        `;
    });

    badge.innerText = totalItensContagem;
    badge.classList.remove('d-none');

    document.getElementById('totalCarrinhoLateral').innerHTML = "R$ " + totalDinheiro.toFixed(2);
}

// Remove item direto pela gaveta lateral
function removerLat(index) {
    carrinho.splice(index, 1);
    salvarCarrinho();
}

// Executa a carga inicial ao montar a tela
atualizarVisualLateral();
carregarCategorias();
carregarProdutos();
</script>

<?= $this->endSection() ?>
