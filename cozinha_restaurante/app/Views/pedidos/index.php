<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>

.card{

    border:none;

    border-radius:15px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.filtros{

    background:#f8f9fa;

    border-radius:15px;

    padding:20px;

    margin-bottom:25px;

}

.badge{

    padding:8px 12px;

    border-radius:20px;

}

.table td{

    vertical-align:middle;

}

</style>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>

            Pedidos

        </h2>

        <p class="text-muted">

            Gerenciamento de pedidos do restaurante

        </p>

    </div>

</div>

<div class="card mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>

Data Inicial

</label>

<input

type="date"

name="inicio"

value="<?= $inicio ?>"

class="form-control">

</div>

<div class="col-md-4">

<label>

Data Final

</label>

<input

type="date"

name="fim"

value="<?= $fim ?>"

class="form-control">

</div>

<div class="col-md-4">

<label>

Status

</label>

<select

name="status"

class="form-select">

<option value="">

Todos

</option>

<option

value="Em preparo"

<?= $status=="Em preparo" ? 'selected' : '' ?>>

Em preparo

</option>

<option

value="Finalizado"

<?= $status=="Finalizado" ? 'selected' : '' ?>>

Finalizado

</option>

<option

value="Cancelado"

<?= $status=="Cancelado" ? 'selected' : '' ?>>

Cancelado

</option>

</select>

</div>

</div>

<div class="mt-3">

<button

class="btn btn-primary">

Atualizar

</button>

<a

href="<?= base_url('pedidos') ?>"

class="btn btn-secondary">

Limpar

</a>

</div>

</form>

</div>

</div>

<div class="card">

<div class="card-body">

<table

id="pedidos"

class="table table-hover table-striped align-middle">

<thead class="table-dark">

<tr>

<th>

Pedido

</th>

<th>

Cliente

</th>

<th>

Telefone

</th>

<th>

Status

</th>

<th>

Valor

</th>

<th>

Data

</th>

<th width="240">

Ações

</th>

</tr>

</thead>

<tbody>

<?php foreach($pedidos as $pedido): ?>

<tr>

<td>

<strong>

#<?= $pedido['numero_pedido'] ?>

</strong>

</td>

<td>

<?= esc($pedido['cliente_nome']) ?>

</td>

<td>

<?= esc($pedido['cliente_telefone']) ?>

</td>

<td>

<?php

switch(strtolower($pedido['status'])){

    case 'finalizado':

        echo '<span class="badge bg-success">Finalizado</span>';

        break;

    case 'cancelado':

        echo '<span class="badge bg-danger">Cancelado</span>';

        break;

    default:

        echo '<span class="badge bg-warning text-dark">'.$pedido['status'].'</span>';

}

?>

</td>

<td>

<strong>

R$

<?= number_format(

$pedido['valor_total'],

2,

',',

'.'

) ?>

</strong>

</td>

<td>

<?= date(

'd/m/Y H:i',

strtotime($pedido['data_pedido'])

) ?>

</td>

<td>

<a

href="<?= base_url('pedidos/'.$pedido['id']) ?>"

class="btn btn-primary btn-sm">

<i class="bi bi-eye"></i>

Ver

</a>

<?php if(strtolower($pedido['status']) != 'finalizado'): ?>

<a

href="<?= base_url('pedidos/finalizar/'.$pedido['id']) ?>"

class="btn btn-success btn-sm"

onclick="return confirm('Finalizar este pedido?')">

<i class="bi bi-check-circle"></i>

Finalizar

</a>

<?php endif; ?>

<?php if(strtolower($pedido['status']) != 'cancelado'): ?>

<a

href="<?= base_url('pedidos/cancelar/'.$pedido['id']) ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Cancelar este pedido?')">

<i class="bi bi-x-circle"></i>

Cancelar

</a>

<?php endif; ?>

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

    $('#pedidos').DataTable({

        responsive:true,

        pageLength:10,

        order:[[5,'desc']],

        language:{

            url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'

        },

        columnDefs:[

            {

                orderable:false,

                targets:6

            }

        ]

    });

});

</script>

<?= $this->endSection() ?>