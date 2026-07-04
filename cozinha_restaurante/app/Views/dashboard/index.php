<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<h2 class="mb-4">

Dashboard

</h2>

<div class="row">

    <div class="col-md-3">

        <div class="card card-dashboard text-center">

            <div class="card-body">

                <h5>Pedidos</h5>

                <h2>

                    <?= $pedidos ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-dashboard text-center">

            <div class="card-body">

                <h5>Produtos</h5>

                <h2>

                    <?= $produtos ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-dashboard text-center">

            <div class="card-body">

                <h5>Usuários</h5>

                <h2>

                    <?= $usuarios ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-dashboard text-center">

            <div class="card-body">

                <h5>Faturamento</h5>

                <h2>

                    R$

                    <?= number_format(
                        $faturamento,
                        2,
                        ',',
                        '.'
                    ) ?>

                </h2>

            </div>

        </div>

    </div>

</div>

<hr class="my-5">

<h4>

Acesso Rápido

</h4>

<div class="row">

<?php if(session('usuario_perfil')=="SUPER_ADMIN"): ?>

<div class="col-md-3">

<a
href="<?= base_url('usuarios') ?>"
class="btn btn-primary w-100 p-4">

Gerenciar Usuários

</a>

</div>

<?php endif; ?>

<div class="col-md-3">

<a
href="<?= base_url('vendas') ?>"
class="btn btn-success w-100 p-4">

Painel de Vendas

</a>

</div>

<div class="col-md-3">

<a
href="<?= base_url('perfil') ?>"
class="btn btn-warning w-100 p-4">

Meu Perfil

</a>

</div>

<div class="col-md-3">

<button
class="btn btn-secondary w-100 p-4"
disabled>

Painel Consumo

</button>

</div>

</div>

<?= $this->endSection() ?>