<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title><?= $title ?? 'Totem Restaurante' ?></title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"
rel="stylesheet">

<script src="<?= base_url('js/config.js') ?>"></script>

<style>

body{

    background:#f5f5f5;
    min-height:100vh;
    padding-bottom:70px;

}

.produtos-area{

    margin-right:360px;
    padding:20px;

}

.carrinho-area{

    position:fixed;
    right:0;
    top:0;
    width:350px;
    height:100vh;
    background:white;
    box-shadow:-5px 0 15px rgba(0,0,0,.1);
    padding:20px;
    overflow:auto;

}

.categoria-btn{

    margin-right:10px;
    margin-bottom:10px;

}

.produto-card{

    cursor:pointer;
    transition:.2s;

}

.produto-card:hover{

    transform:translateY(-5px);

}

.produto-card img{

    height:220px;
    object-fit:cover;

}

/*==============================*/
/* Rodapé do Totem              */
/*==============================*/

.footer-totem{

    position:fixed;

    bottom:0;

    left:0;

    width:100%;

    height:55px;

    background:#212529;

    color:white;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 25px;

    z-index:1040;

    transition:all .30s ease;

    box-shadow:0 -2px 10px rgba(0,0,0,.15);

}

/* Quando o carrinho estiver aberto */

.footer-totem.com-carrinho{

    width:calc(100% - 400px);

}

.status-online{

    color:#00d26a;

    font-weight:bold;

}

.status-offline{

    color:#ff4d4d;

    font-weight:bold;

}

</style>

</head>

<body>

<!-- Overlay de Ativação do Totem -->

<div
    id="overlayAtivacao"
    style="
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.85);
        z-index:2000;
        display:none;
        align-items:center;
        justify-content:center;
        padding:20px;">

    <div style="background:#fff;border-radius:16px;padding:40px;max-width:420px;width:100%;text-align:center;">

        <i class="bi bi-pc-display" style="font-size:2.5rem;"></i>

        <h3 class="fw-bold mt-3 mb-2">Ativação do Totem</h3>

        <p class="text-muted mb-4">
            Digite a chave de ativação cadastrada pelo administrador para este totem.
        </p>

        <input
            type="text"
            id="inputChaveAtivacao"
            class="form-control form-control-lg text-center mb-2"
            placeholder="Ex: A1B2C3"
            style="letter-spacing:4px;text-transform:uppercase;font-weight:700;"
            maxlength="20">

        <div
            id="erroChaveAtivacao"
            class="text-danger small mb-3"
            style="display:none;">

            Chave inválida ou totem inativo. Tente novamente.

        </div>

        <button
            id="btnAtivarTotem"
            class="btn btn-dark w-100 py-2 fw-semibold mt-2"
            onclick="ativarTotemComChave()">

            Ativar Totem

        </button>

    </div>

</div>

<?= $this->renderSection('content') ?>

<!-- Rodapé do Totem -->

<div class="footer-totem">

    <div>

        <i class="bi bi-pc-display"></i>

        <strong id="totemNumero">

            Totem --

        </strong>

    </div>

    <div id="statusServidor">

        <span class="status-online">

            <i class="bi bi-circle-fill"></i>

            Servidor Online

        </span>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('js/totem-status.js') ?>"></script>

<script>

/*====================================================
| Ajusta o rodapé quando o carrinho lateral abrir
=====================================================*/

document.addEventListener("DOMContentLoaded",function(){

    const footer = document.querySelector(".footer-totem");

    const carrinho = document.getElementById("carrinhoLateral");

    if(!footer || !carrinho){

        return;

    }

    function atualizarFooter(){

        if(carrinho.classList.contains("aberto")){

            footer.classList.add("com-carrinho");

        }else{

            footer.classList.remove("com-carrinho");

        }

    }

    atualizarFooter();

    const observer = new MutationObserver(function(){

        atualizarFooter();

    });

    observer.observe(carrinho,{

        attributes:true,

        attributeFilter:["class"]

    });

});

</script>

</body>

</html> 