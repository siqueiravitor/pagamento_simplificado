<?php use App\Core\FlashView; ?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">

    <title>
        Acessar
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Vitor Siqueira" name="author" />
    <meta content="Pagamento simplificado" name="description" />
    <link rel="shortcut icon" href="/assets/images/logos/logo.png">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet">
    <link href="/assets/css/app.min.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet">

    <style>
        .btn-show-password {
            background: white;
            border: 1px solid var(--bs-input-border-color);
            border-left: 0;
        }

        .input-group-text {
            background: white;
            border: 1px solid var(--bs-input-border-color);
            border-right: 0;
        }
    </style>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</head>

<body>
    <div id="layout-wrapper">
        <div class="d-flex justify-content-center align-items-center bg-dark bg-soft" style="height: 100vh;">
            <div class="container card p-4 shadow-sm" style="max-width: 480px;">
                <div class="content-header mb-2 pb-2 mx-5 border-bottom text-center">
                    <h4 class="mb-0 text-accent">Bem-vindos!</h4>
                    <small>Faça o login para acessar a plataforma</small>
                </div>
                <?php FlashView::render(); ?>

                <form action="/login" method="POST" autocomplete="off" class="card-body">
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email de acesso" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" placeholder="Senha de acesso"
                            required id="password">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember-me" id="remember"
                            onclick="togglePassword()">
                        <label class="form-check-label" for="remember">Mostrar senha</label>
                    </div>

                    <button class="btn btn-info w-100">Acessar</button>
                </form>

                <div class="text-center mt-4">
                    © <?= date('Y') ?> | Construído por
                    <a href="https://vitorsiqueira.com">Vitor
                        Siqueira</a>
                </div>
            </div>
        </div>

    </div>
</body>

</html>