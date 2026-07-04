<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Usuários</h2>

        <p class="text-muted mb-0">
            Gerenciamento de usuários do sistema.
        </p>

    </div>

    <a
        href="<?= base_url('usuarios/novo') ?>"
        class="btn btn-success">

        <i class="bi bi-plus-circle"></i>

        Novo Usuário

    </a>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Nome</th>

                    <th>Email</th>

                    <th>Perfil</th>

                    <th>Status</th>

                    <th width="220">

                        Ações

                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($usuarios as $usuario): ?>

                <tr>

                    <td>

                        <?= $usuario['id'] ?>

                    </td>

                    <td>

                        <?= esc($usuario['nome']) ?>

                    </td>

                    <td>

                        <?= esc($usuario['email']) ?>

                    </td>

                    <td>

                        <?php if($usuario['perfil']=="SUPER_ADMIN"): ?>

                            <span class="badge bg-primary">

                                Super Admin

                            </span>

                        <?php else: ?>

                            <span class="badge bg-secondary">

                                Usuário

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <?php if($usuario['ativo']): ?>

                            <span class="badge bg-success">

                                Ativo

                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger">

                                Bloqueado

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a
                            href="<?= base_url('usuarios/editar/'.$usuario['id']) ?>"
                            class="btn btn-warning btn-sm">

                            Editar

                        </a>

                        <?php if($usuario['ativo']): ?>

                            <a
                                href="<?= base_url('usuarios/bloquear/'.$usuario['id']) ?>"
                                class="btn btn-danger btn-sm">

                                Bloquear

                            </a>

                        <?php else: ?>

                            <a
                                href="<?= base_url('usuarios/desbloquear/'.$usuario['id']) ?>"
                                class="btn btn-success btn-sm">

                                Desbloquear

                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?> 