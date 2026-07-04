<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">

                        Restaurante

                    </h2>

                    <?php if(session()->getFlashdata('erro')): ?>

                        <div class="alert alert-danger">

                            <?= session()->getFlashdata('erro') ?>

                        </div>

                    <?php endif; ?>

                    <form method="post" action="<?= base_url('login') ?>">

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Senha</label>

                            <input
                                type="password"
                                name="senha"
                                class="form-control"
                                required>

                        </div>

                        <button
                            class="btn btn-primary w-100">

                            Entrar

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>