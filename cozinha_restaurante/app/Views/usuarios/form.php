<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<?php

$editando = isset($usuario);

?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm">

            <div class="card-header">

                <h4 class="mb-0">

                    <?= $editando ? 'Editar Usuário' : 'Novo Usuário' ?>

                </h4>

            </div>

            <div class="card-body">

                <form
                    method="post"
                    action="<?= $editando
                        ? base_url('usuarios/atualizar/'.$usuario['id'])
                        : base_url('usuarios/salvar') ?>">

                    <div class="mb-3">

                        <label class="form-label">

                            Nome

                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            required
                            value="<?= $editando ? esc($usuario['nome']) : '' ?>">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                            value="<?= $editando ? esc($usuario['email']) : '' ?>">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Senha

                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            <?= $editando ? '' : 'required' ?>>

                        <?php if($editando): ?>

                            <small class="text-muted">

                                Deixe em branco para manter a senha atual.

                            </small>

                        <?php endif; ?>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Perfil

                        </label>

                        <select
                            name="perfil"
                            class="form-select">

                            <option
                                value="SUPER_ADMIN"
                                <?= ($editando && $usuario['perfil']=="SUPER_ADMIN") ? 'selected' : '' ?>>

                                Super Admin

                            </option>

                            <option
                                value="USUARIO"
                                <?= ($editando && $usuario['perfil']=="USUARIO") ? 'selected' : '' ?>>

                                Usuário

                            </option>

                        </select>

                    </div>

                    <hr>

                    <button
                        class="btn btn-success">

                        Salvar

                    </button>

                    <a
                        href="<?= base_url('usuarios') ?>"
                        class="btn btn-secondary">

                        Cancelar

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>