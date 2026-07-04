<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title><?= $title ?? 'Sistema Restaurante' ?></title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"
rel="stylesheet">

<style>

body{

    background:#f4f6f9;
    overflow-x:hidden;

}

.sidebar{

    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:#212529;
    color:white;
    overflow-y:auto;

}

.sidebar h3{

    padding:20px;
    text-align:center;
    border-bottom:1px solid #444;
    margin-bottom:0;

}

.sidebar a{

    color:white;
    display:block;
    text-decoration:none;
    padding:15px 20px;
    transition:.2s;

}

.sidebar a:hover{

    background:#343a40;

}

.sidebar a.active{

    background:#0d6efd;

}

.menu-title{

    padding:12px 20px 6px;
    font-size:.75rem;
    color:#adb5bd;
    text-transform:uppercase;
    letter-spacing:1px;

}

.topbar{

    margin-left:250px;
    height:70px;
    background:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);

}

.content{

    margin-left:250px;
    margin-top:70px;
    padding:30px;

}

.card-dashboard{

    border:none;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

</style>

</head>

<body>

<div class="sidebar">

    <h3>

        Restaurante

    </h3>

    <div class="menu-title">

        Principal

    </div>

    <a href="<?= base_url('dashboard') ?>">

        <i class="bi bi-speedometer2"></i>

        Dashboard

    </a>

    <a href="<?= base_url('consumo') ?>">

        <i class="bi bi-bar-chart-line-fill"></i>

        Painel de Consumo

    </a>

    <a href="<?= base_url('vendas') ?>">

        <i class="bi bi-graph-up-arrow"></i>

        Painel de Vendas

    </a>

<?php if(session('usuario_perfil')=="SUPER_ADMIN"): ?>

    <div class="menu-title">

        Administração

    </div>

    <a href="<?= base_url('categorias') ?>">

        <i class="bi bi-tags"></i>

        Categorias

    </a>

    <a href="<?= base_url('produtos') ?>">

        <i class="bi bi-box-seam"></i>

        Produtos

    </a>

    <a href="<?= base_url('totens') ?>">

        <i class="bi bi-pc-display"></i>

        Totens

    </a>

    <a href="<?= base_url('usuarios') ?>">

        <i class="bi bi-people"></i>

        Usuários

    </a>

<?php endif; ?>

    <div class="menu-title">

        Conta

    </div>

    <a href="<?= base_url('perfil') ?>">

        <i class="bi bi-person-circle"></i>

        Meu Perfil

    </a>

    <a href="<?= base_url('logout') ?>">

        <i class="bi bi-box-arrow-right"></i>

        Sair

    </a>

</div>

<div class="topbar">

    <div>

        <h5 class="mb-0">

            <?= session('usuario_nome') ?>

        </h5>

        <small>

            <?= session('usuario_perfil') ?>

        </small>

    </div>

    <div>

        <?= date('d/m/Y H:i') ?>

    </div>

</div>

<div class="content">

    <?= $this->renderSection('content') ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>