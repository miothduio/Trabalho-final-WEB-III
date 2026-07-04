<?= $this->extend('layouts/painel') ?>

<?= $this->section('content') ?>

<style>

.detalhes-container{ max-width:900px; margin:auto; }

.detalhes-card{
    background:#fff;
    border:1px solid #eef2f5;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,.02);
    padding:32px;
}

.numero-pedido-badge{
    background:#212529;
    color:#fff;
    padding:8px 18px;
    border-radius:8px;
    font-weight:700;
    display:inline-block;
}

.item-producao{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 0;
    border-bottom:1px dotted #dee2e6;
}

.item-producao:last-child{ border-bottom:none; }

.indicador-card{
    border:none;
    background:#f8f9fa;
    border-radius:12px;
}

.indicador-card h3{ font-weight:700; margin:0; }

</style>

<div class="container-fluid">
<div class="detalhes-container">

<div class="mb-4">
    <a href="<?= base_url() ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Voltar para o Painel
    </a>
</div>

<div id="conteudoDetalhe">
    <div class="text-center text-muted py-5">Carregando comanda...</div>
</div>

</div>
</div>

<script>
const pedidoId = <?= (int) $id ?>;

function minutosEntre(inicio, fim){
    if (!inicio) return 0;
    const diff = Math.floor((fim - inicio) / 60000);
    return diff < 0 ? 0 : diff;
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.innerText = texto ?? '';
    return div.innerHTML;
}

function montarAcoes(status){
    if (status === 'PENDENTE') {
        return `
        <div class="row g-3">
            <div class="col-md-6">
                <button class="btn btn-danger btn-lg w-100" onclick="mudarStatus('cancelar')">
                    <i class="bi bi-x-circle-fill"></i> Cancelar Pedido
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary btn-lg w-100" onclick="mudarStatus('preparar')">
                    <i class="bi bi-fire"></i> Iniciar Preparo
                </button>
            </div>
        </div>`;
    }

    if (status === 'EM_PREPARO') {
        return `
        <div class="row g-3">
            <div class="col-md-6">
                <button class="btn btn-danger btn-lg w-100" onclick="mudarStatus('cancelar')">
                    <i class="bi bi-x-circle-fill"></i> Cancelar Pedido
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-success btn-lg w-100" onclick="mudarStatus('finalizar')">
                    <i class="bi bi-check-circle-fill"></i> Finalizar Pedido
                </button>
            </div>
        </div>`;
    }

    if (status === 'FINALIZADO') {
        return `<div class="alert alert-success text-center py-4 mb-0"><h4 class="mb-2"><i class="bi bi-check-circle-fill"></i> Pedido Finalizado</h4><p class="mb-0">Este pedido foi concluído com sucesso.</p></div>`;
    }

    if (status === 'CANCELADO') {
        return `<div class="alert alert-danger text-center py-4 mb-0"><h4 class="mb-2"><i class="bi bi-x-circle-fill"></i> Pedido Cancelado</h4><p class="mb-0">Este pedido foi cancelado.</p></div>`;
    }

    return '';
}

async function carregarDetalhe(){
    const container = document.getElementById('conteudoDetalhe');

    try {
        const resposta = await fetch(API_BASE + '/pedidos/' + pedidoId);
        const json = await resposta.json();

        if (!json.status) {
            container.innerHTML = '<div class="alert alert-danger text-center">Pedido não encontrado.</div>';
            return;
        }

        const pedido = json.pedido;
        const itens = json.itens;

        const dataPedido = new Date(pedido.data_pedido.replace(' ', 'T'));
        const horaInicio = pedido.hora_inicio ? new Date(pedido.hora_inicio.replace(' ', 'T')) : null;
        const horaFim = pedido.hora_fim ? new Date(pedido.hora_fim.replace(' ', 'T')) : null;

        const tempoEspera = minutosEntre(dataPedido, horaInicio || new Date());
        const tempoPreparo = horaInicio ? minutosEntre(horaInicio, horaFim || new Date()) : '--';

        const linhasItens = itens.map(item => `
            <div class="item-producao">
                <div>
                    <strong class="fs-5">${escapeHtml(item.nome)}</strong>
                    ${item.observacao ? `<br><small class="text-danger">Observação: ${escapeHtml(item.observacao)}</small>` : ''}
                </div>
                <div class="bg-dark text-white rounded px-3 py-2">${item.quantidade}x</div>
            </div>
        `).join('');

        container.innerHTML = `
        <div class="detalhes-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div>
                    <span class="text-muted small">IDENTIFICAÇÃO</span><br>
                    <div class="numero-pedido-badge mt-2">Pedido Nº ${String(pedido.id).padStart(5, '0')}</div>
                </div>
                <span class="badge bg-dark px-3 py-2">${pedido.status}</span>
            </div>

            <div class="bg-light rounded-3 p-3 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted small">CLIENTE</span>
                        <h5 class="fw-bold mt-1">${escapeHtml(pedido.cliente_nome)}</h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted small">TELEFONE</span>
                        <h6 class="mt-1">${pedido.cliente_telefone ? escapeHtml(pedido.cliente_telefone) : 'Não informado'}</h6>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card indicador-card text-center"><div class="card-body">
                        <small class="text-muted d-block">⏳ Tempo de Espera</small>
                        <h3 class="${tempoEspera >= 10 ? 'text-danger' : 'text-success'}">${tempoEspera} min</h3>
                    </div></div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card indicador-card text-center"><div class="card-body">
                        <small class="text-muted d-block">👨‍🍳 Tempo de Preparo</small>
                        <h3 class="${tempoPreparo === '--' ? 'text-secondary' : (tempoPreparo >= 15 ? 'text-danger' : 'text-primary')}">${tempoPreparo === '--' ? '--' : tempoPreparo + ' min'}</h3>
                    </div></div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card indicador-card text-center"><div class="card-body">
                        <small class="text-muted d-block">💰 Valor Total</small>
                        <h3 class="text-success">R$ ${Number(pedido.valor_total).toFixed(2).replace('.', ',')}</h3>
                    </div></div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card indicador-card text-center"><div class="card-body">
                        <small class="text-muted d-block">📦 Itens</small>
                        <h3>${itens.length}</h3>
                    </div></div>
                </div>
            </div>

            <div class="mb-3"><h5>Itens do Pedido</h5></div>
            <div class="border-top border-bottom mb-4">${linhasItens}</div>

            <div class="border-top pt-4">${montarAcoes(pedido.status)}</div>
        </div>
        `;
    } catch (e) {
        container.innerHTML = '<div class="alert alert-danger text-center">Erro ao carregar a comanda.</div>';
        console.error(e);
    }
}

async function mudarStatus(acao){
    if (acao === 'cancelar' && !confirm('Deseja realmente cancelar este pedido?')) {
        return;
    }

    try {
        await fetch(API_BASE + '/pedidos/' + pedidoId + '/' + acao, { method: 'POST' });
        carregarDetalhe();
    } catch (e) {
        alert('Não foi possível atualizar o pedido.');
    }
}

carregarDetalhe();
</script>

<?= $this->endSection() ?>
