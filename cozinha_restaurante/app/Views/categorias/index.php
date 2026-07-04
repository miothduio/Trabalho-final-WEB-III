<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>

            Categorias

        </h2>

        <p class="text-muted">

            Gerenciamento das categorias dos produtos.

        </p>

    </div>

    <a
        href="<?= base_url('categorias/novo') ?>"
        class="btn btn-success">

        <i class="bi bi-plus-circle"></i>

        Nova Categoria

    </a>

</div>

<?php if(session()->getFlashdata('sucesso')): ?>

<div class="alert alert-success">

    <?= session()->getFlashdata('sucesso') ?>

</div>

<?php endif; ?>

<?php if(session()->getFlashdata('erro')): ?>

<div class="alert alert-danger">

    <?= session()->getFlashdata('erro') ?>

</div>

<?php endif; ?>

<div class="card shadow-sm">

    <div class="card-body">

        <table
            id="categorias"
            class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th width="80">

                        ID

                    </th>

                    <th>

                        Categoria

                    </th>

                    <th width="180">

                        Produtos

                    </th>

                    <th width="180">

                        Ações

                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($categorias as $categoria): ?>

                <tr>

                    <td>

                        <?= $categoria['id'] ?>

                    </td>

                    <td>

                        <strong>

                            <?= esc($categoria['nome']) ?>

                        </strong>

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            <?= $categoria['total_produtos'] ?>

                            Produtos

                        </span>

                    </td>

                    <td>

                        <a

                            href="<?= base_url('categorias/editar/'.$categoria['id']) ?>"

                            class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil-square"></i>

                            Editar

                        </a>

                        <a

                            href="<?= base_url('categorias/excluir/'.$categoria['id']) ?>"

                            class="btn btn-danger btn-sm"

                            onclick="return confirm('Deseja realmente excluir esta categoria?')">

                            <i class="bi bi-trash"></i>

                            Excluir

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<link
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

    $('#categorias').DataTable({

        responsive:true,

        pageLength:10,

        order:[[1,'asc']],

        language:{

            url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'

        }

    });

});

</script>

<?= $this->endSection() ?>