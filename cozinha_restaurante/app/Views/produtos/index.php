<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>

            Produtos

        </h2>

        <p class="text-muted">

            Gerenciamento dos produtos do restaurante.

        </p>

    </div>

    <a
        href="<?= base_url('produtos/novo') ?>"
        class="btn btn-success">

        <i class="bi bi-plus-circle"></i>

        Novo Produto

    </a>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <table
            id="produtos"
            class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th width="90">

                        Foto

                    </th>

                    <th>

                        Produto

                    </th>

                    <th>

                        Categoria

                    </th>

                    <th>

                        Preço

                    </th>

                    <th>

                        Estoque

                    </th>

                    <th>

                        Destaque

                    </th>

                    <th>

                        Status

                    </th>

                    <th width="170">

                        Ações

                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($produtos as $produto): ?>

                <?php

                $imagem = !empty($produto['imagem'])

                    ? base_url($produto['imagem'])

                    : 'https://placehold.co/80x80';

                ?>

                <tr>

                    <td>

                        <img

                        src="<?= $imagem ?>"

                        class="rounded"

                        style="

                        width:70px;

                        height:70px;

                        object-fit:cover;

                        ">

                    </td>

                    <td>

                        <strong>

                            <?= esc($produto['nome']) ?>

                        </strong>

                        <br>

                        <small class="text-muted">

                            <?= esc($produto['descricao']) ?>

                        </small>

                    </td>

                    <td>

                        <?= esc($produto['categoria']) ?>

                    </td>

                    <td>

                        R$

                        <?= number_format(

                            $produto['preco'],

                            2,

                            ',',

                            '.'

                        ) ?>

                    </td>

                    <td>

                        <?= $produto['estoque'] ?>

                    </td>

                    <td>

                        <?php if($produto['destaque']): ?>

                            <span class="badge bg-warning text-dark">

                                Sim

                            </span>

                        <?php else: ?>

                            <span class="badge bg-secondary">

                                Não

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <?php if($produto['ativo']): ?>

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
                            href="<?= base_url('produtos/editar/'.$produto['id']) ?>"
                            class="btn btn-warning btn-sm">

                            Editar

                        </a>

                        <a
                            href="<?= base_url('produtos/excluir/'.$produto['id']) ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Deseja realmente excluir este produto?')">

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

    $('#produtos').DataTable({

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