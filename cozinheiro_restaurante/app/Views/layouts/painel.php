<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title><?= $title ?? 'Painel da Cozinha' ?></title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"
rel="stylesheet">

<script src="<?= base_url('js/config.js') ?>"></script>

<style>

body{

    background:#f4f6f9;

    overflow-x:hidden;

}

.topbar{

    height:70px;

    background:#212529;

    color:white;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:0 30px;

    box-shadow:0 2px 8px rgba(0,0,0,.08);

}

.topbar h5{

    color:white;

}

.topbar small{

    color:#adb5bd!important;

}

.content{

    padding:30px;

}

</style>

</head>

<body>

<div class="topbar">

    <div>

        <h5 class="mb-0"><i class="bi bi-fire"></i> Cozinha</h5>

        <small>
            Acompanhamento dos pedidos em tempo real
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
