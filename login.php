<?php
session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
} else {
    header("Location: ./");
    exit;
}
?>
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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="source/js/windowmsg.js"></script>
        <script type="text/javascript" src="source/js/openlink.js"></script>
        
        <link rel="stylesheet" type="text/css" href="source/css/default.css">
        <link rel="stylesheet" type="text/css" href="source/css/login.css">

    </head>
    <body>
        <div class="login text-bg-danger">
            <div class="container position-relative" style="max-width: 400px;">
                <a href="#" onclick="AbrirLink('.');"><img class="logo" src="source/img/website/logo-white.png" alt="Imoideal"/></a>
                <!-- Abas de Entrar e Criar Conta -->
                <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" onclick="signin = true;" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Entrar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" onclick="signin = false;" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Criar Conta</a>
                    </li>
                </ul>

                <!-- Conteúdo das Abas -->
                <div class="tab-content p-4 text-bg-light" id="loginTabsContent">
                    <!-- Aba Entrar (aberta por padrão) -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <!-- Conteúdo da aba Entrar -->
                        <form>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" id="InputEmail" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="name@example.com">
                                <label for="InputEmail" class="text-muted">E-mail</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="InputPassword" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="********">
                                <label for="InputPassword" class="text-muted">Senha</label>
                            </div>
                            <div class="mb-3">
                                <a href="#" onclick="AbrirLink('#');">Esqueci minha senha</a>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" onclick="FazerLogin();" class="btn btn-outline-danger">Entrar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Aba Criar Conta -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <!-- Conteúdo da aba Criar Conta -->
                        <form>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" id="RegisterEmail" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="name@example.com">
                                <label for="RegisterEmail" class="text-muted">E-mail</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="RegisterName" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="Seu nome">
                                <label for="RegisterNam" class="text-muted">Nome</label>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><small class="text-muted">+55</small></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="RegisterTel" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="00 0000-0000">
                                    <label for="RegisterTel" class="text-muted">Whatsapp</label>
                                </div>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="RegisterPassword" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="********">
                                <label for="RegisterPassword" class="text-muted">Senha</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="RegisterConfirm" oninput="OnInput(this);" onchange="OnChange(this);" autocomplete="off" placeholder="********">
                                <label for="RegisterConfirm" class="text-muted">Confirmar Senha</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" onclick="CriarLogin();" class="btn btn-outline-danger">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript" src="source/js/login.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>