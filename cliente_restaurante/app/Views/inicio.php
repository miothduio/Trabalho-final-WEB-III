<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lancheria IF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa; /* Fundo claro e elegante padrão */
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #212529;
            cursor: pointer; /* Transforma o cursor em mãozinha na tela toda */
            overflow: hidden; /* Evita barras de rolagem */
            user-select: none; /* Impede seleção de texto ao tocar na tela */
        }

        .totem-brand-title {
            font-weight: 800;
            letter-spacing: -1px;
            color: #212529;
        }

        /* Texto de instrução principal que substitui o botão */
        .touch-to-start {
            font-size: 1.5rem;
            font-weight: 700;
            color: #212529;
            letter-spacing: 0.5px;
            display: inline-block;
            padding: 12px 24px;
            animation: pulsarTexto 2s infinite ease-in-out; /* Faz a frase pulsar para chamar atenção */
        }

        /* Animação suave de pulsação para o texto */
        @keyframes pulsarTexto {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }
    </style>
</head>

<body onclick="redirecionar()">

<div class="container">
    <div class="row vh-100 align-items-center justify-content-center">
        <div class="col-md-6 text-center">

            <div class="mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" 
                     width="180" 
                     alt="Lancheria IF" 
                     class="img-fluid"
                     style="filter: drop-shadow(0px 15px 20px rgba(0,0,0,0.04));">
            </div>

            <h1 class="totem-brand-title mb-2 display-3">Lancheria IF</h1>
            <p class="text-muted fs-5 mb-5">Seja bem-vindo! Que tal um lanche hoje?</p>

            <div class="mt-5 pt-3">
                <span class="touch-to-start">
                    👋 TOQUE NA TELA PARA COMEÇAR
                </span>
            </div>

        </div>
    </div>
</div>

<script>
    const urlProdutos = "<?= base_url('produtos') ?>";

    function redirecionar() {
        window.location.href = urlProdutos;
    }
</script>

</body>
</html>