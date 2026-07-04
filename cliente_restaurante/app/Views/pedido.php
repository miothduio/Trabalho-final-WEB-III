<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo do Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?= base_url('js/config.js') ?>"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #212529;
        }

        .pedido-container {
            max-width: 650px;
            margin: 0 auto;
        }

        .pedido-card {
            background: #ffffff;
            border: 1px solid #eef2f5;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
            padding: 32px;
        }

        .numero-pedido-box {
            background-color: #f1f3f5;
            border-radius: 12px;
            padding: 12px 24px;
            display: inline-block;
        }

        .table-pedido {
            margin-bottom: 0;
        }

        .table-pedido th {
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 2px solid #f1f3f5;
            padding: 12px 8px;
        }

        .table-pedido td {
            padding: 16px 8px;
            vertical-align: middle;
            border-bottom: 1px dotted #dee2e6;
            color: #495057;
        }

        .table-pedido tr:last-child td {
            border-bottom: none;
        }

        .btn-novo-pedido {
            background-color: #212529;
            color: #ffffff !important;
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-novo-pedido:hover {
            background-color: #000000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="pedido-container" id="conteudoPedido">
        <div class="text-center text-muted py-5">Carregando pedido...</div>
    </div>
</div>

<script>
const pedidoId = <?= (int) $id ?>;

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.innerText = texto ?? '';
    return div.innerHTML;
}

function formatarMoeda(valor) {
    return Number(valor).toFixed(2).replace('.', ',');
}

function formatarData(dataStr) {
    const data = new Date(dataStr.replace(' ', 'T'));
    return data.toLocaleDateString('pt-BR') + ' ' + data.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

async function carregarPedido() {
    const container = document.getElementById('conteudoPedido');

    try {
        const resposta = await fetch(API_BASE + '/pedidos/' + pedidoId);
        const json = await resposta.json();

        if (!json.status) {
            container.innerHTML = '<div class="alert alert-danger text-center">Pedido não encontrado.</div>';
            return;
        }

        const pedido = json.pedido;
        const itens = json.itens;

        const linhasItens = itens.map(item => `
            <tr>
                <td>
                    <span class="fw-bold text-dark">${escapeHtml(item.nome)}</span>
                    ${item.observacao ? `<br><small class="text-danger">Obs: "${escapeHtml(item.observacao)}"</small>` : ''}
                </td>
                <td class="text-center fw-semibold">${item.quantidade}</td>
                <td class="text-end text-muted">R$ ${formatarMoeda(item.valor_unitario)}</td>
                <td class="text-end fw-bold text-dark">R$ ${formatarMoeda(item.quantidade * item.valor_unitario)}</td>
            </tr>
        `).join('');

        container.innerHTML = `
            <div class="text-center mb-4">
                <div class="text-success mb-2" style="font-size: 3.5rem; line-height: 1;">✓</div>
                <h2 class="fw-bold m-0">Pedido Recebido!</h2>
                <p class="text-muted">Acompanhe os detalhes da sua requisição abaixo</p>
            </div>

            <div class="pedido-card">
                <div class="text-center mb-4">
                    <span class="text-muted small text-uppercase fw-semibold">Número do Pedido</span>
                    <br>
                    <div class="numero-pedido-box mt-2">
                        <h2 class="fw-bold text-dark m-0" style="letter-spacing: 1px;">
                            #${String(pedido.id).padStart(5, '0')}
                        </h2>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-4">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <span class="small text-muted text-uppercase d-block">Cliente</span>
                            <strong class="text-dark">${escapeHtml(pedido.cliente_nome)}</strong>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <span class="small text-muted text-uppercase d-block">Data / Hora</span>
                            <span class="text-dark fw-semibold">${formatarData(pedido.data_pedido)}</span>
                        </div>
                        ${pedido.cliente_telefone ? `
                        <div class="col-12 border-top mt-2 pt-2">
                            <span class="small text-muted">📞 Contato: ${escapeHtml(pedido.cliente_telefone)}</span>
                        </div>` : ''}
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-pedido align-middle">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-end">Unitário</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>${linhasItens}</tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-2">
                    <span class="fs-5 fw-bold text-dark">Total do Pedido:</span>
                    <span class="fs-3 fw-bold text-success">R$ ${formatarMoeda(pedido.valor_total)}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?= base_url() ?>" class="btn-novo-pedido shadow-sm">Fazer um Novo Pedido</a>
            </div>
        `;
    } catch (e) {
        container.innerHTML = '<div class="alert alert-danger text-center">Erro ao carregar o pedido.</div>';
        console.error(e);
    }
}

carregarPedido();
</script>

</body>
</html>
