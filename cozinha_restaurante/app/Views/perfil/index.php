<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow-sm">

<div class="card-header">

<h4>

Meu Perfil

</h4>

</div>

<div class="card-body">

<?php if(session()->getFlashdata('sucesso')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('sucesso') ?>

</div>

<?php endif; ?>

<form
method="post"
action="<?= base_url('perfil') ?>">

<div class="mb-3">

<label>

Nome

</label>

<input

type="text"

name="nome"

class="form-control"

value="<?= esc($usuario['nome']) ?>"

required>

</div>

<div class="mb-3">

<label>

Email

</label>

<input

type="email"

name="email"

class="form-control"

value="<?= esc($usuario['email']) ?>"

required>

</div>

<div class="mb-3">

<label>

Nova Senha

</label>

<input

type="password"

name="senha"

class="form-control">

<small class="text-muted">

Deixe em branco para manter a senha atual.

</small>

</div>

<button

class="btn btn-success">

Salvar Alterações

</button>

</form>

</div>

</div>

</div>

</div>

<?= $this->endSection() ?>