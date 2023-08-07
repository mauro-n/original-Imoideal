<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ImoIdeal - Acesso a conta</title>
        <meta name='title' content='ImoIdeal - Acesso a conta'>
        <meta name='keywords' content='aluguel, compra, terreno, casa, apartamento, quarto, terrenos, casas, apartamentos, quartos, imodeal'>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name="robots" content="noindex, nofollow">
        <meta name="robots" content="no-index, no-follow">
        <meta name='language' content='Portuguese'>
        <meta name='author' content='Imodeal.com'>

        <link rel="apple-touch-icon" sizes="57x57" href="source/img/favicon/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="source/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="source/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="source/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="source/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="source/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="source/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="source/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="source/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="source/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="source/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="source/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="source/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="source/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="source/img/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="source/css/login.css">
        <script type="text/javascript" src="source/js/login.js"></script>

    </head>
    <body onload="Inicializa();">
        <div class="login text-bg-danger">
            <div class="container position-relative" style="max-width: 400px;">
                <a href="."><img class="logo" src="source/img/website/logo-white.png" alt="Imoideal"/></a>
                <!-- Abas de Entrar e Criar Conta -->
                <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Entrar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Criar Conta</a>
                    </li>
                </ul>

                <!-- Conteúdo das Abas -->
                <div class="tab-content p-4 text-bg-light" id="loginTabsContent">
                    <!-- Aba Entrar (aberta por padrão) -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <!-- Conteúdo da aba Entrar -->
                        <form>
                            <div class="mb-2">
                                <label for="loginEmail" class="form-label"><i class="bi bi-envelope text-muted me-1"></i>Email</label>
                                <input type="email" class="form-control" id="InputEmail" oninput="OnInput(this);">
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label"><i class="bi bi-lock text-muted me-1"></i>Senha</label>
                                <input type="password" class="form-control" id="InputPassword" oninput="OnInput(this);">
                            </div>
                            <div class="mb-3">
                                <a href="#">Esqueci minha senha</a>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-danger">Entrar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Aba Criar Conta -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <!-- Conteúdo da aba Criar Conta -->
                        <form>
                            <div class="mb-3">
                                <label for="RegisterEmail" class="form-label"><i class="bi bi-envelope text-muted me-1"></i>Email</label>
                                <input type="email" class="form-control" id="RegisterEmail" oninput="OnInput(this);">
                            </div>
                            <div class="mb-3">
                                <label for="RegisterName" class="form-label"><i class="bi bi-person text-muted me-1"></i>Nome</label>
                                <input type="text" class="form-control" id="RegisterName" oninput="OnInput(this);">
                            </div>
                            <div class="mb-3">
                                <label for="RegisterTel" class="form-label"><i class="bi bi-whatsapp text-muted me-1"></i>Whatsapp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><small class="text-muted">+55</small></span>
                                    <input type="text" class="form-control" id="RegisterTel" oninput="OnInput(this);">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="RegisterPassword" class="form-label"><i class="bi bi-lock text-muted me-1"></i>Senha</label>
                                <input type="password" class="form-control" id="RegisterPassword" oninput="OnInput(this);">
                            </div>
                            <div class="mb-3">
                                <label for="RegisterConfirm" class="form-label"><i class="bi bi-lock text-muted me-1"></i>Confirmar Senha</label>
                                <input type="password" class="form-control" id="RegisterConfirm" oninput="OnInput(this);">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-danger">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>