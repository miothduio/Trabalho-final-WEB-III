<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?= base_url('js/config.js') ?>"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #212529;
        }

        .checkout-box {
            background: #ffffff;
            border: 1px solid #eef2f5;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            padding: 24px;
        }

        .resumo-checkout {
            background-color: #ffffff;
            border: 1px solid #eef2f5;
            border-radius: 12px;
            padding: 24px;
            position: sticky;
            top: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .item-resumo-minimo {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
            color: #495057;
            padding: 8px 0;
            border-bottom: 1px solid #f1f3f5;
        }
        .item-resumo-minimo:last-child {
            border-bottom: none;
        }

        .form-control {
            border-color: #ddebf7;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        }

        .btn-confirmar {
            background-color: #198754;
            color: #ffffff !important;
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-confirmar:hover {
            background-color: #157347;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }
        
        .btn-confirmar:disabled {
            background-color: #a3cfbb;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('carrinho') ?>" class="btn btn-outline-dark btn-sm mb-2">← Alterar Itens</a>
        <h1 class="fw-bold m-0">Finalizar Pedido</h1>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="checkout-box">
                <h4 class="fw-bold mb-4 text-dark">Seus Dados</h4>
                
                <form id="formCheckout" onsubmit="event.preventDefault(); enviarPedido();">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="nome" class="form-label fw-semibold small text-muted text-uppercase">Nome Completo</label>
                            <input type="text" id="nome" class="form-control" placeholder="Digite seu nome completo" required>
                            <div class="invalid-feedback">Por favor, informe seu nome.</div>
                        </div>

                        <div class="col-md-12">
                            <label for="telefone" class="form-label fw-semibold small text-muted text-uppercase">Telefone / WhatsApp</label>
                            <input type="text" id="telefone" class="form-control" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="resumo-checkout">
                <h5 class="fw-bold mb-3">Revisão do Pedido</h5>
                
                <div id="listaItensCheckout" class="mb-3 max-height-200 overflow-y-auto pe-1">
                    </div>

                <hr class="text-mutedmy-3">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fs-5 fw-bold">Total a Pagar:</span>
                    <span id="totalCheckout" class="fs-4 fw-bold text-success">R$ 0,00</span>
                </div>

                <button id="btnEnviar" onclick="enviarPedido()" class="btn btn-confirmar w-100 d-flex align-items-center justify-content-center gap-2">
                    <span id="btnTexto">Confirmar e Finalizar Pedido</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Recupera dados do localStorage
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

// Injeta os dados financeiros e itens na interface ao carregar a página
function carregarResumoCheckout() {
    const listaHtml = document.getElementById('listaItensCheckout');
    let total = 0;

    if (carrinho.length === 0) {
        alert('Seu carrinho está vazio!');
        window.location = '<?= base_url("produtos") ?>';
        return;
    }

    listaHtml.innerHTML = '';
    
    carrinho.forEach(item => {
        let subtotal = item.preco * item.quantidade;
        total += subtotal;

        listaHtml.innerHTML += `
            <div class="item-resumo-minimo">
                <span>
                    <strong class="text-dark">${item.quantidade}x</strong> ${item.nome}
                </span>
                <span class="fw-semibold">R$ ${subtotal.toFixed(2)}</span>
            </div>
        `;
    });

    document.getElementById('totalCheckout').innerText = "R$ " + total.toFixed(2);
}

async function enviarPedido() {
    let nomeInput = document.getElementById('nome');
    let nome = nomeInput.value;
    let telefone = document.getElementById('telefone').value;
    
    // Elementos de feedback visual do botão
    let btnEnviar = document.getElementById('btnEnviar');
    let btnTexto = document.getElementById('btnTexto');
    let btnSpinner = document.getElementById('btnSpinner');

    // Validação nativa bonita
    if (nome.trim() === '') {
        nomeInput.classList.add('is-invalid');
        nomeInput.focus();
        return;
    } else {
        nomeInput.classList.remove('is-invalid');
    }

    if (carrinho.length === 0) {
        alert('Seu carrinho está vazio.');
        return;
    }

    let total = 0;
    carrinho.forEach(item => {
        total += item.preco * item.quantidade;
    });

    let pedido = {
        nome: nome,
        telefone: telefone,
        valor_total: total,
        numero_totem: ((JSON.parse(localStorage.getItem('totem_dados')) || {}).numero_totem || 0),
        itens: carrinho
    };

    // Ativa estado de carregamento (Evita cliques repetidos enviados à API)
    btnEnviar.disabled = true;
    btnTexto.innerText = "Processando Pedido...";
    btnSpinner.classList.remove('d-none');

    try {
        let resposta = await fetch(API_BASE + '/pedidos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pedido)
        });

        let dados = await resposta.json();

        if (dados.status) {
            localStorage.removeItem('carrinho');
            window.location = '<?= base_url("pedido") ?>/' + dados.pedido;
        } else {
            alert('Houve um erro no servidor ao tentar salvar seu pedido.');
            resetarBotao();
        }
    } catch (erro) {
        alert('Erro de comunicação com o servidor. Verifique sua conexão.');
        resetarBotao();
    }
}

function resetarBotao() {
    let btnEnviar = document.getElementById('btnEnviar');
    let btnTexto = document.getElementById('btnTexto');
    let btnSpinner = document.getElementById('btnSpinner');
    
    btnEnviar.disabled = false;
    btnTexto.innerText = "Confirmar e Finalizar Pedido";
    btnSpinner.classList.add('d-none');
}

// Inicializa a renderização dos valores na montagem da tela
carregarResumoCheckout();
</script>

</body>
</html>