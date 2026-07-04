<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                Totens

            </h2>

            <small class="text-muted">

                Gerenciamento dos totens de autoatendimento

            </small>

        </div>

        <a
            href="<?= base_url('totens/novo') ?>"
            class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Novo Totem

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th width="80">

                                Nº

                            </th>

                            <th>

                                Chave

                            </th>

                            <th>

                                IP

                            </th>

                            <th>

                                Hostname

                            </th>

                            <th>

                                Descrição

                            </th>

                            <th width="150">

                                Ativação

                            </th>

                            <th width="120">

                                Status

                            </th>

                            <th width="170">

                                Ações

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(empty($totens)): ?>

<tr>

    <td colspan="8" class="text-center py-5">

        <i class="bi bi-pc-display fs-1 text-muted"></i>

        <br><br>

        <span class="text-muted">

            Nenhum totem cadastrado.

        </span>

    </td>

</tr>

<?php else: ?>

<?php foreach($totens as $totem): ?>

<tr>

    <td>

        <span class="badge bg-primary fs-6">

            <?= esc($totem['numero_totem']) ?>

        </span>

    </td>

    <td>

        <code
            class="chave-copiavel"
            role="button"
            title="Clique para copiar"
            style="letter-spacing:1px;cursor:pointer;"
            onclick="copiarChave(this, '<?= esc($totem['chave'], 'js') ?>')">

            <?= esc($totem['chave']) ?>

            <i class="bi bi-clipboard ms-1 text-muted"></i>

        </code>

    </td>

    <td>

        <code>

            <?= !empty($totem['ip']) ? esc($totem['ip']) : '--' ?>

        </code>

    </td>

    <td>

        <?= !empty($totem['hostname'])
            ? esc($totem['hostname'])
            : '<span class="text-muted">Não informado</span>' ?>

    </td>

    <td>

        <?= !empty($totem['descricao'])
            ? esc($totem['descricao'])
            : '<span class="text-muted">Sem descrição</span>' ?>

    </td>

    <td>

        <?php if($totem['ativado']): ?>

            <span class="badge bg-success">Ativado</span>

        <?php else: ?>

            <span class="badge bg-warning text-dark">Aguardando</span>

        <?php endif; ?>

    </td>

    <td>

        <?php if($totem['ativo']): ?>

            <span class="badge bg-success">

                Ativo

            </span>

        <?php else: ?>

            <span class="badge bg-danger">

                Inativo

            </span>

        <?php endif; ?>

    </td>

    <td>

        <a
            href="<?= base_url('totens/editar/'.$totem['id']) ?>"
            class="btn btn-warning btn-sm">

            <i class="bi bi-pencil-square"></i>

        </a>

        <a
            href="<?= base_url('totens/excluir/'.$totem['id']) ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Deseja realmente excluir este totem?')">

            <i class="bi bi-trash"></i>

        </a>

    </td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>
function copiarChave(elemento, chave) {
    navigator.clipboard.writeText(chave).then(function () {
        const original = elemento.innerHTML;

        elemento.innerHTML = chave + ' <i class="bi bi-check-lg text-success ms-1"></i>';

        setTimeout(function () {
            elemento.innerHTML = original;
        }, 1500);
    });
}
</script>

<?= $this->endSection() ?>