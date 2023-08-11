<?php
require_once 'source/sys/class/Container.php';
require_once 'source/sys/class/Session.php';

$session = new Session();
$session->RefreshSession();

$path = "";
if (isset($_GET['filtro'])) {
    $path = "../";
} else {
    $path = "";
}

$html = new Container($path);
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <base href="pesquisa.php"/> 

        <title>Pesquisa - ImoIdeal</title>
        <meta name='title' content='Pesquisa - ImoIdeal'>
        <meta name='keywords' content='aluguel, compra, terreno, casa, apartamento, quarto, terrenos, casas, apartamentos, quartos, imodeal'>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name="robots" content="noindex, nofollow">
        <meta name="robots" content="no-index, no-follow">
        <meta name='language' content='Portuguese'>
        <meta name='author' content='Imodeal.com'>

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $path; ?>source/img/favicon/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $path; ?>source/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $path; ?>source/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $path; ?>source/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $path; ?>source/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $path; ?>source/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $path; ?>source/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $path; ?>source/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $path; ?>source/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $path; ?>source/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $path; ?>source/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $path; ?>source/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $path; ?>source/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo $path; ?>source/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo $path; ?>source/img/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/pesquisa.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/rodape.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo $path; ?>source/js/pesquisa.js"></script>
    </head>
    <body onload="Inicializa();">
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container">
            <div class="box-search">
                <form class="form-search">
                    <div class="row">
                        <div class="col-md-2  mb-2">
                            <select id="PesqCateg" class="form-select">
                                <option>Apartamento</option>
                                <option>Casa</option>
                                <option>Terreno</option>
                                <option>Quarto</option>
                            </select>
                        </div>
                        <div class="col-md-2  mb-2">
                            <select id="PesqType" class="form-select">
                                <option>Alugar</option>
                                <option>Comprar</option>
                            </select>
                        </div>
                        <div class="col-md mb-2" id="opt-containe">
                            <input type="text" id="PesqText" class="form-control" oninput="OnWriting(this);" placeholder="Local" aria-label="Local">
                            <div class="options-container noshow" id="options-container">
                            </div>
                        </div>
                        <div class="col-md-2  mb-2">
                            <button type="button" onclick="Pesquisar();" style="width: 100%;" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="mt-0">
            <h5 class="w-100 text-center mb-4">Anúncios</h5>
            <div class="row anuclinks">
                <div class="col-md-3 mb-4">
                    <div class="card text-bg-danger w-100 mb-0 p-3">
                        <h6 class="card-title w-100 text-center mt-0 mb-0 dropdown-toggle dropdown-toggle-split" data-bs-toggle="collapse" data-bs-target="#filterCollapse">Filtros &nbsp;<span class="visually-hidden">Toggle Dropdown</span></h6>
                        <div id="filterCollapse" class="collapse show">
                            <hr>
                            <p class="card-text w-100">Ordem</p>
                            <select class="form-select" name="bedrooms">
                                <option value="">Adicionados Recentes</option>
                                <option value="1">Mais Barato (0-9)</option>
                                <option value="2">Mais Caro (9-0)</option>
                            </select>
                            <hr>
                            <p class="card-text w-100">Quartos</p>
                            <div class="input-group mb-2">
                                <select class="form-select" name="bedrooms">
                                    <option value="">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5 ou mais</option>
                                </select>
                            </div>
                            <hr>
                            <p class="card-text w-100">Metros</p>
                            <div class="input-group mb-2">
                                <span class="input-group-text">De&nbsp;<small class="text-muted">(m²)</small></span>
                                <input type="number" class="form-control" id="minPrice" name="minPrice">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Até&nbsp;<small class="text-muted">(m²)</small></span>
                                <input type="number" class="form-control" id="maxPrice" name="maxPrice">
                            </div>
                            <hr>
                            <p class="card-text w-100">Faixa de Preço</p>
                            <div class="input-group mb-2">
                                <span class="input-group-text">De&nbsp;<small class="text-muted">(R$)</small></span>
                                <input type="number" class="form-control" id="minPrice" name="minPrice">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Até&nbsp;<small class="text-muted">(R$)</small></span>
                                <input type="number" class="form-control" id="maxPrice" name="maxPrice">
                            </div>
                            <hr>
                            <button type="button" class="btn w-100 btn-outline-light"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md mb-4">
                    <a href="anuncio">
                        <div class="card anunc w-100 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="img-anuncio" style="background-image: url(<?php echo $path; ?>source/img/anuncio/anunc1.webp);"></div>
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
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="anuncio">
                        <div class="card anunc w-100 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="img-anuncio" style="background-image: url(<?php echo $path; ?>source/img/anuncio/anunc2.webp);"></div>
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
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="anuncio">
                        <div class="card anunc w-100 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="img-anuncio" style="background-image: url(<?php echo $path; ?>source/img/anuncio/anuc3.jpg);"></div>
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

        <script type="text/javascript">
            $(document).ready(function () {
                // Adicionar a classe "show" ao collapse apenas na versão desktop
                function adjustCollapseVisibility() {
                    if ($(window).width() >= 768) { // Tamanho de tela desktop (md)
                        $("#filterCollapse").addClass("show");
                    } else {
                        $("#filterCollapse").removeClass("show");
                    }
                }

                // Chamar a função no carregamento da página e sempre que a tela for redimensionada
                adjustCollapseVisibility();
                $(window).resize(adjustCollapseVisibility);
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>