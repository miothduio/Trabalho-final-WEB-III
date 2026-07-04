<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

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
    transform: translateY(-4px);
}
.indicador h2 {
    font-weight: bold;
}
.indicador i {
    font-size: 40px;
}
.table img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
}
.table td {
    vertical-align: middle;
}
.filtros {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
}
.dataTables_wrapper .dataTables_filter input {
    border-radius: 10px;
}
.dataTables_wrapper .dataTables_length select {
    border-radius: 10px;
}
.badge {
    padding: 8px 12px;
    border-radius: 20px;
}
</style>

<h2 class="mb-4">Painel de Consumo</h2>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-box-seam text-primary"></i>
                <h2><?= esc($totalProdutos) ?></h2>
                <p class="mb-0">Produtos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-check-circle text-success"></i>
                <h2><?= esc($ativos) ?></h2>
                <p class="mb-0">Disponíveis</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-cart-check text-warning"></i>
                <h2><?= esc($vendidos) ?></h2>
                <p class="mb-0">Itens Vendidos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card indicador">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack text-danger"></i>
                <h2>R$ <?= number_format($faturamentoTotal, 2, ',', '.') ?></h2>
                <p class="mb-0">Faturamento</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="">
            <div class="filtros">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas</option>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?= esc($categoria['id']) ?>" <?= $categoriaSelecionada == $categoria['id'] ? 'selected' : '' ?>>
                                    <?= esc($categoria['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Inicial</label>
                        <input type="date" name="inicio" value="<?= esc($inicio) ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Final</label>
                        <input type="date" name="fim" value="<?= esc($fim) ?>" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-arrow-repeat"></i> Atualizar
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <table id="consumo" class="table table-hover table-striped align-middle" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Disponível</th>
                    <th>Estoque</th>
                    <th>Vendidos</th>
                    <th>Faturamento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($produtos as $produto): ?>
                    <?php
                    $imagem = !empty($produto['imagem'])
                        ? base_url($produto['imagem'])
                        : 'https://placehold.co/70x70';
                    ?>
                    <tr>
                        <td>
                            <img src="<?= $imagem ?>" class="img-thumbnail" alt="<?= esc($produto['nome']) ?>">
                        </td>
                        <td>
                            <strong><?= esc($produto['nome']) ?></strong>
                        </td>
                        <td>
                            <?= esc($produto['categoria']) ?>
                        </td>
                        <td>
                            <?php if($produto['ativo']): ?>
                                <span class="badge bg-success">Disponível</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Indisponível</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= esc($produto['estoque']) ?>
                        </td>
                        <td>
                            <?= esc($produto['vendidos']) ?>
                        </td>
                        <td>
                            <strong>R$ <?= number_format($produto['faturamento'], 2, ',', '.') ?></strong>
                        </td>
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
    $('#consumo').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']], // Ordena pela segunda coluna (Produto)
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
        },
        columnDefs: [
            {
                orderable: false,
                targets: 0 // Desativa ordenação na coluna da Foto
            }
        ]
    });
});
</script>

<?= $this->endSection() ?>