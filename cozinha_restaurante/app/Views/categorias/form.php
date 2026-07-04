<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<?php

$editando = isset($categoria);

?>

<div class="row justify-content-center">

    <div class="col-lg-6">

        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <h3 class="mb-0">

                    <?= $editando ? 'Editar Categoria' : 'Nova Categoria' ?>

                </h3>

            </div>

            <div class="card-body">

                <form

                    action="<?= $editando
                        ? base_url('categorias/atualizar/'.$categoria['id'])
                        : base_url('categorias/salvar') ?>"

                    method="post">

                    <div class="mb-4">

                        <label class="form-label">

                            Nome da Categoria

                        </label>

                        <input

                            type="text"

                            class="form-control"

                            name="nome"

                            required

                            autofocus

                            value="<?= $editando ? esc($categoria['nome']) : '' ?>">

                    </div>

                    <hr>

                    <div class="d-flex justify-content-end">

                        <a

                            href="<?= base_url('categorias') ?>"

                            class="btn btn-secondary me-2">

                            <i class="bi bi-arrow-left"></i>

                            Cancelar

                        </a>

                        <button

                            type="submit"

                            class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            <?= $editando ? 'Atualizar' : 'Salvar' ?>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>