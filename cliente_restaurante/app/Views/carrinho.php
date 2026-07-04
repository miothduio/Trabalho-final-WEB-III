<?= $this->extend('layouts/totem') ?>

<?= $this->section('content') ?>

<style>
    .carrinho-page-area {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    .carrinho-box {
        background: #ffffff;
        border: 1px solid #eef2f5;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }
    .item-linha {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
        border-bottom: 1px solid #f1f3f5;
    }
    .item-linha:last-child {
        border-bottom: none;
    }
    .resumo-card {
        background-color: #f8f9fa;
        border: 1px solid #eef2f5;
        border-radius: 12px;
        padding: 24px;
        position: sticky;
        top: 20px;
    }
    .btn-finalizar {
        background-color: #198754;
        color: #ffffff !important;
        border: none;
        padding: 14px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-finalizar:hover {
        background-color: #157347;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
    }
</style>

<div class="container carrinho-page-area py-4">
    <div class="mb-4">
        <a href="<?= base_url('produtos') ?>" class="btn btn-outline-dark btn-sm mb-2">← Voltar para os Produtos</a>
        <h1 class="fw-bold m-0">Seu Carrinho</h1>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="carrinho-box p-4" id="containerCarrinhoVazio">
                <div class="text-center py-5">
                    <span style="font-size: 4rem;">🛒</span>
                    <h4 class="mt-3 fw-bold">Seu carrinho está vazio</h4>
                    <p class="text-muted">Volte à tela inicial para adicionar delícias ou produtos.</p>
                    <a href="<?= base_url('produtos') ?>" class="btn btn-dark mt-2">Escolher Produtos</a>
                </div>
            </div>

            <div class="carrinho-box p-4 d-none" id="containerCarrinhoItens">
                <div id="listaItensPagina"></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="resumo-card">
                <h4 class="fw-bold mb-4">Resumo do Pedido</h4>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Subtotal</span>
                    <span id="resumoSubtotal" class="fw-semibold">R$ 0,00</span>
                </div>
                
                <hr class="text-muted">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fs-5 fw-bold">Total:</span>
                    <span id="resumoTotal" class="fs-4 fw-bold text-success">R$ 0,00</span>
                </div>

                <a href="<?= base_url('checkout') ?>" id="btnCheckout" class="btn btn-finalizar w-100 text-center d-block text-decoration-none disabled">
                    Confirmar e Pagar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

function renderizarTelaCarrinho() {
    const containerVazio = document.getElementById('containerCarrinhoVazio');
    const containerItens = document.getElementById('containerCarrinhoItens');
    const listaHtml = document.getElementById('listaItensPagina');
    const btnCheckout = document.getElementById('btnCheckout');
    
    if (carrinho.length === 0) {
        containerVazio.classList.remove('d-none');
        containerItens.classList.add('d-none');
        btnCheckout.classList.add('disabled');
        document.getElementById('resumoSubtotal').innerText = "R$ 0,00";
        document.getElementById('resumoTotal').innerText = "R$ 0,00";
        return;
    }

    containerVazio.classList.add('d-none');
    containerItens.classList.remove('d-none');
    btnCheckout.classList.remove('disabled');

    listaHtml.innerHTML = '';
    let totalGeral = 0;

    carrinho.forEach((item, index) => {
        let subtotal = item.preco * item.quantidade;
        totalGeral += subtotal;

        listaHtml.innerHTML += `
            <div class="item-linha">
                <div style="flex: 1; padding-right: 15px;">
                    <h5 class="fw-bold mb-1">${item.nome}</h5>
                    ${item.observacao ? `<p class="text-muted small mb-2"><strong>Obs:</strong> "${item.observacao}"</p>` : ''}
                    <span class="text-muted small">Unitário: R$ ${item.preco.toFixed(2)}</span>
                </div>
                
                <div class="d-flex align-items-center me-4">
                    <button class="btn btn-sm btn-outline-secondary px-2 py-1" onclick="alterarQuantidade(${index}, -1)">-</button>
                    <span class="mx-3 fw-bold fs-5" style="min-width:20px; text-align:center;">${item.quantidade}</span>
                    <button class="btn btn-sm btn-outline-secondary px-2 py-1" onclick="alterarQuantidade(${index}, 1)">+</button>
                </div>

                <div class="text-end" style="min-width: 110px;">
                    <span class="fw-bold d-block fs-5 text-dark">R$ ${subtotal.toFixed(2)}</span>
                    <button class="btn btn-link text-danger p-0 text-decoration-none small" onclick="removerItem(${index})">
                        Remover
                    </button>
                </div>
            </div>
        `;
    });

    document.getElementById('resumoSubtotal').innerText = "R$ " + totalGeral.toFixed(2);
    document.getElementById('resumoTotal').innerText = "R$ " + totalGeral.toFixed(2);
}

function alterarQuantidade(index, valor) {
    carrinho[index].quantidade += valor;
    if (carrinho[index].quantidade <= 0) {
        carrinho.splice(index, 1);
    }
    salvarEAtualizar();
}

function removerItem(index) {
    carrinho.splice(index, 1);
    salvarEAtualizar();
}

function salvarEAtualizar() {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    renderizarTelaCarrinho();
}

renderizarTelaCarrinho();
</script>

<?= $this->endSection() ?>