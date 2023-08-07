<?php

session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
    header("Location: login");
    exit();
}

require_once './source/sys/class/Container.php';
$html = new Container();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Meus Anúncios - ImoIdeal</title>
        <meta name='title' content='Meus Anúncios - ImoIdeal'>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/meusanuncios.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">

    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container" style="min-height: 500px;">
            <h5 class="w-100 text-center mt-4 mb-4">Meus Anúncios</h5>
            <button class="btn btn-outline-danger w-100 mb-4" type="submit">Novo Anúncio</button>
            <div class="row anuclinks">
                <div class="col-md mb-4">
                    <a href="anuncio">
                        <div class="card anunc w-100 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="img-anuncio" style="background-image: url(source/img/anuncio/anunc1.webp);"></div>
                                    </div>
                                    <div class="col-sm title-anun">
                                        <h5 class="card-title mb-1">Card title</h5>
                                        <p class="card-text mb-1 text-muted"><small>Rua Monsenhor Luis Santiago, 647<br><small>Fortaleza - CE</small></small></p>
                                        <div class="w-100">
                                            <span class="badge rounded-pill text-bg-secondary">Chuveiro Eletrico</span>
                                            <span class="badge rounded-pill text-bg-secondary">Churrasqueira</span>
                                            <span class="badge rounded-pill text-bg-secondary">2 Quartos</span>
                                            <span class="badge rounded-pill text-bg-secondary">1 Suite</span>
                                            <span class="badge rounded-pill text-bg-secondary">Mobiliado</span>
                                            <span class="badge rounded-pill text-bg-secondary">Sem Fiador</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 prec-anun text-end">
                                        <h5 class="card-title">R$ 1.800<small><small class="text-muted">/mês</small></small></h5>
                                    </div>
                                    <div class="col-sm-1 opcs-anunc">
                                        <div class="edit-anunc"><i class="fa-regular fa-pen-to-square"></i></div>
                                        <div class="del-anunc"><i class="fa-regular fa-trash-can"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>