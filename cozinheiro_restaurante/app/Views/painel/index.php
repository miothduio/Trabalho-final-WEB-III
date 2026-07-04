<?= $this->extend('layouts/painel') ?>

<?= $this->section('content') ?>

<style>

.titulo-painel{
    font-weight:700;
    color:#212529;
}

.comanda-card{
    background:#fff;
    border:1px solid #eef2f5;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.02);
    transition:.2s;
}

.comanda-card:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 35px rgba(0,0,0,.05);
}

.borda-status-pendente{ border-left:6px solid #ffc107; }
.borda-status-preparo{ border-left:6px solid #0d6efd; }
.borda-status-pronto{ border-left:6px solid #198754; }
.borda-status-cancelado{ border-left:6px solid #dc3545; }

.comanda-header{
    padding:16px 20px;
    border-bottom:1px solid #f1f3f5;
}

.comanda-body{
    padding:20px;
}

.badge-status{
    font-size:.75rem;
    font-weight:600;
    padding:6px 12px;
    border-radius:50px;
    letter-spacing:.5px;
}

.btn-abrir-comanda{
    background:#212529;
    color:#fff!important;
    text-decoration:none;
    display:block;
    width:100%;
    text-align:center;
    padding:12px;
    border-radius:8px;
    font-weight:600;
    transition:.2s;
}

.btn-abrir-comanda:hover{
    background:#000;
}

.transition-all{
    transition:.3s;
}

.filtro-btn{
    margin-right:8px;
    margin-bottom:8px;
}

</style>

<div class="container-fluid">

    <div class="mb-5 d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h1 class="titulo-painel m-0">Painel de Pedidos</h1>
            <p class="text-muted mt-1 mb-0">Gerenciamento e produção em tempo real</p>
        </div>

        <div>
            <span id="ping-badge" class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fw-semibold rounded-3 transition-all">
                ● Atualizando ao Vivo
            </span>
        </div>

    </div>

    <div class="mb-4">
        <button class="btn btn-dark filtro-btn" onclick="filtrarPedidos('TODOS')">Todos</button>
        <button class="btn btn-warning filtro-btn" onclick="filtrarPedidos('PENDENTE')">Pendentes</button>
        <button class="btn btn-primary filtro-btn" onclick="filtrarPedidos('EM_PREPARO')">Em Preparo</button>
        <button class="btn btn-success filtro-btn" onclick="filtrarPedidos('FINALIZADO')">Finalizados</button>
        <button class="btn btn-danger filtro-btn" onclick="filtrarPedidos('CANCELADO')">Cancelados</button>
    </div>

    <div class="row g-4" id="conteiner-pedidos">
        <div class="col-12 text-center text-muted py-5">Carregando pedidos...</div>
    </div>

</div>

<script>
const pingBadge = document.getElementById("ping-badge");
const conteinerPedidos = document.getElementById("conteiner-pedidos");
let filtroAtual = "TODOS";

function classesStatus(statusAtual){
    switch (statusAtual) {
        case 'EM_PREPARO':
            return { borda: 'borda-status-preparo', badge: 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25' };
        case 'FINALIZADO':
            return { borda: 'borda-status-pronto', badge: 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' };
        case 'CANCELADO':
            return { borda: 'borda-status-cancelado', badge: 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25' };
        default:
            return { borda: 'borda-status-pendente', badge: 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25' };
    }
}

function minutosEntre(inicio, fim){
    if (!inicio) return 0;
    const diff = Math.floor((fim - inicio) / 60000);
    return diff < 0 ? 0 : diff;
}

function montarCard(pedido){
    const statusAtual = (pedido.status || '').toUpperCase();
    const cores = classesStatus(statusAtual);

    const dataPedido = new Date(pedido.data_pedido.replace(' ', 'T'));
    const horaPedido = dataPedido.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

    const horaInicio = pedido.hora_inicio ? new Date(pedido.hora_inicio.replace(' ', 'T')) : null;
    const horaFim = pedido.hora_fim ? new Date(pedido.hora_fim.replace(' ', 'T')) : null;

    const tempoEspera = minutosEntre(dataPedido, horaInicio || new Date());
    const tempoPreparo = horaInicio ? minutosEntre(horaInicio, horaFim || new Date()) : '--';

    return `
    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 mb-4 pedido-card" data-status="${statusAtual}">
        <div class="comanda-card ${cores.borda} h-100">
            <div class="comanda-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1">Pedido #${String(pedido.id).padStart(5, '0')}</h5>
                        <small class="text-primary fw-semibold d-block">
                            <i class="bi bi-display"></i>
                            Totem ${String(pedido.numero_totem || 0).padStart(2, '0')}
                        </small>
                        <small class="text-muted">${horaPedido}</small>
                    </div>
                    <span class="badge-status ${cores.badge}">${pedido.status}</span>
                </div>
            </div>
            <div class="comanda-body">
                <div class="mb-3">
                    <small class="text-uppercase text-muted">Cliente</small>
                    <h5 class="fw-bold mb-0">${pedido.cliente_nome}</h5>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-3">
                        <small class="text-muted d-block">Espera</small>
                        <strong class="${tempoEspera >= 10 ? 'text-danger' : 'text-success'}">${tempoEspera} min</strong>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Preparo</small>
                        <strong>${tempoPreparo === '--' ? '--' : `<span class="${tempoPreparo >= 15 ? 'text-danger' : 'text-primary'}">${tempoPreparo} min</span>`}</strong>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Valor</small>
                        <strong>R$ ${Number(pedido.valor_total).toFixed(2).replace('.', ',')}</strong>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Itens</small>
                        <strong>${pedido.total_itens ?? '--'}</strong>
                    </div>
                </div>
            </div>
            <div class="p-3 border-top bg-light">
                <a href="<?= base_url('pedido/') ?>${pedido.id}" class="btn btn-dark w-100">
                    <i class="bi bi-list-check"></i> Abrir Comanda
                </a>
            </div>
        </div>
    </div>
    `;
}

function filtrarPedidos(status){
    filtroAtual = status;

    document.querySelectorAll(".pedido-card").forEach(function(card){
        card.style.display = (status === "TODOS" || card.dataset.status === status) ? "" : "none";
    });
}

async function carregarPedidos(){
    pingBadge.className = "badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 fw-semibold rounded-3 transition-all";
    pingBadge.innerHTML = "● Sincronizando...";

    try {
        const resposta = await fetch(API_BASE + '/pedidos');
        const pedidos = await resposta.json();

        conteinerPedidos.innerHTML = pedidos.length
            ? pedidos.map(montarCard).join('')
            : `<div class="col-12 text-center py-5"><div class="alert alert-light border shadow-sm"><h5 class="mb-2">🍽️ Nenhum pedido na fila</h5><span class="text-muted">Assim que um novo pedido for realizado ele aparecerá aqui.</span></div></div>`;

        filtrarPedidos(filtroAtual);

        pingBadge.className = "badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fw-semibold rounded-3 transition-all";
        pingBadge.innerHTML = "● Atualizando ao Vivo";
    } catch (e) {
        pingBadge.className = "badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 fw-semibold rounded-3 transition-all";
        pingBadge.innerHTML = "⚠ Erro de Conexão";
        console.error(e);
    }
}

carregarPedidos();
setInterval(carregarPedidos, 5000);
</script>

<?= $this->endSection() ?>
