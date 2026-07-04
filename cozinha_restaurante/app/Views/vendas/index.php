<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,.08);
}
.indicador {
    transition: .2s;
}
.indicador:hover {
    transform: translateY(-5px);
}
.indicador i {
    font-size: 40px;
}
.filtros {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 20px;
}
.table td {
    vertical-align: middle;
}
.badge {
    padding: 8px 12px;
    border-radius: 20px;
}
</style>

<h2 class="mb-4">Painel de Vendas</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack text-success"></i>
                <h3>R$ <?= number_format($faturamento, 2, ',', '.') ?></h3>
                <p class="mb-0">Faturamento</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-receipt text-primary"></i>
                <h3><?= esc($pedidos) ?></h3>
                <p class="mb-0">Pedidos</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-graph-up text-warning"></i>
                <h3>R$ <?= number_format($ticketMedio, 2, ',', '.') ?></h3>
                <p class="mb-0">Ticket Médio</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Data Inicial</label>
                    <input type="date" name="inicio" value="<?= esc($inicio) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data Final</label>
                    <input type="date" name="fim" value="<?= esc($fim) ?>" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat"></i> Atualizar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Faturamento por Dia</h5>
    </div>
    <div class="card-body">
        <div style="position: relative; height:300px; width:100%;">
            <canvas id="graficoVendas"></canvas>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Pedidos</h5>
    </div>
    <div class="card-body">
        <table id="tabela" class="table table-hover table-striped align-middle" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Nº Pedido</th>
                    <th>Cliente</th>
                    <th>Telefone</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendas as $pedido): ?>
                    <tr>
                        <td><strong><?= esc($pedido['numero_pedido']) ?></strong></td>
                        <td><?= esc($pedido['cliente_nome']) ?></td>
                        <td><?= esc($pedido['cliente_telefone']) ?></td>
                        <td>
                            <?php
                            $status = strtolower($pedido['status']);
                            switch($status){
                                case 'finalizado':
                                    echo '<span class="badge bg-success">Finalizado</span>';
                                    break;
                                case 'cancelado':
                                    echo '<span class="badge bg-danger">Cancelado</span>';
                                    break;
                                default:
                                    echo '<span class="badge bg-warning text-dark">'.esc($pedido['status']).'</span>';
                            }
                            ?>
                        </td>
                        <td><strong>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function(){
    $('#tabela').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[5, 'desc']], // Ordena por data decrescente
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
        }
    });
});

const labels = [
    <?php foreach($grafico as $item): ?>
        '<?= date("d/m", strtotime($item['dia'])) ?>',
    <?php endforeach; ?>
];

const valores = [
    <?php foreach($grafico as $item): ?>
        <?= (float)($item['total'] ?? 0) ?>,
    <?php endforeach; ?>
];

const ctx = document.getElementById('graficoVendas').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Faturamento R$',
            data: valores,
            backgroundColor: 'rgba(13, 110, 253, 0.8)',
            borderColor: 'rgb(13, 110, 253)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?= $this->endSection() ?>