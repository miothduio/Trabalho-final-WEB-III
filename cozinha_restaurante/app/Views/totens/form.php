<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-dark text-white">

                    <h4 class="mb-0">

                        <?= $title ?>

                    </h4>

                </div>

                <div class="card-body">

                    <form
                        action="<?= $acao ?>"
                        method="post">

                        <?php if (!empty($totem)): ?>

                        <div class="mb-3">

                            <label class="form-label">

                                Chave de Ativação

                            </label>

                            <div class="input-group">

                                <input
                                    type="text"
                                    id="inputChaveTotem"
                                    class="form-control"
                                    readonly
                                    style="letter-spacing:2px;font-weight:700;"
                                    value="<?= esc($totem['chave']) ?>">

                                <button
                                    type="button"
                                    id="btnCopiarChave"
                                    class="btn btn-outline-secondary"
                                    onclick="copiarChaveForm()">

                                    <i class="bi bi-clipboard"></i> Copiar

                                </button>

                                <a
                                    href="<?= base_url('totens/chave/'.$totem['id']) ?>"
                                    class="btn btn-outline-danger"
                                    onclick="return confirm('Gerar uma nova chave invalida a chave atual. O totem físico precisará ser ativado de novo. Continuar?')">

                                    <i class="bi bi-arrow-repeat"></i> Gerar Nova

                                </a>

                            </div>

                            <small class="text-muted">
                                <?= $totem['ativado']
                                    ? '<span class="badge bg-success">Ativado</span> IP atual: ' . (esc($totem['ip']) ?: 'ainda não conectou')
                                    : '<span class="badge bg-warning text-dark">Aguardando ativação</span> Informe esta chave na tela do totem.' ?>
                            </small>

                        </div>

                        <?php endif; ?>

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Número do Totem

                                </label>

                                <input
                                    type="number"
                                    name="numero_totem"
                                    class="form-control"
                                    required
                                    min="1"
                                    value="<?= old('numero_totem', $totem['numero_totem'] ?? '') ?>">

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Hostname

                            </label>

                            <input
                                type="text"
                                name="hostname"
                                class="form-control"
                                placeholder="TOTEM-01"
                                value="<?= old('hostname', $totem['hostname'] ?? '') ?>">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Descrição

                            </label>

                            <input
                                type="text"
                                name="descricao"
                                class="form-control"
                                placeholder="Ex.: Entrada Principal"
                                value="<?= old('descricao', $totem['descricao'] ?? '') ?>">

                        </div>

                        <div class="form-check form-switch mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="ativo"
                                name="ativo"
                                value="1"
                                <?= old('ativo', $totem['ativo'] ?? 1) ? 'checked' : '' ?>>

                            <label
                                class="form-check-label"
                                for="ativo">

                                Totem Ativo

                            </label>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a
                                href="<?= base_url('totens') ?>"
                                class="btn btn-secondary">

                                <i class="bi bi-arrow-left"></i>

                                Voltar

                            </a>

                            <button
                                type="submit"
                                class="btn btn-success">

                                <i class="bi bi-check-circle"></i>

                                Salvar

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function copiarChaveForm() {
    const input = document.getElementById('inputChaveTotem');
    const btn = document.getElementById('btnCopiarChave');

    navigator.clipboard.writeText(input.value).then(function () {
        const original = btn.innerHTML;

        btn.innerHTML = '<i class="bi bi-check-lg"></i> Copiado!';

        setTimeout(function () {
            btn.innerHTML = original;
        }, 1500);
    });
}
</script>

<?= $this->endSection() ?>