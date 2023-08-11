<?php
require_once './source/sys/class/Container.php';
require_once './source/sys/class/Session.php';

$session = new Session();
$session->RefreshSession();

$html = new Container();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- SEO -->
        <?php
        echo $html->WriteSEO("Imoideal - Home", "Encontre as melhores opções de aluguel e compra de imóveis no ImoIdeal. Explore uma ampla variedade de casas, apartamentos, terrenos e quartos disponíveis para locação e compra. Navegue por listagens detalhadas, visualize fotos de alta qualidade e encontre a propriedade perfeita para atender às suas necessidades. Somos a sua fonte confiável para encontrar o lar dos seus sonhos. Comece a sua busca hoje mesmo no ImoIdeal.");
        ?>

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

        <link rel="stylesheet" type="text/css" href="source/css/index.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="source/js/pesquisa.js"></script>

        <script>
            // URL da API do ipinfo.io para obter informações de localização por IP
            const apiUrl = 'https://ipinfo.io?token=ae250d4afdb5ad';

            // Função para fazer a requisição à API e obter os dados de localização
            function getCityFromIP() {
                fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            const city = data.city; // A cidade do usuário
                            console.log(`Você está na cidade de ${city}`);
                        })
                        .catch(error => {
                            console.error('Erro ao obter informações de localização:', error);
                        });
            }

            // Chamando a função para obter a cidade
            getCityFromIP();
        </script>
    </head>
    <body onload="Inicializa();">
        <?php
        echo $html->WriteMenu();
        ?>

        <div class="search">
            <div class="img-back">
                <h3>O melhor lugar para comprar ou alugar casa no Brasil<br><small><small><small>Encontre seu novo lar</small></small></small></h3>
                <div class="box-search">
                    <form class="form-search">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <select id="PesqCateg" class="form-select">
                                    <option>Apartamento</option>
                                    <option>Casa</option>
                                    <option>Terreno</option>
                                    <option>Quarto</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
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
                            <div class="col-md-2 mb-2">
                                <button type="button" onclick="Pesquisar();" style="width: 100%;" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container principal">
            <h3>Anúncios destacados</h3>
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc1.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Jardim das Oliveiras</p>
                                            <p class="tamanh">100 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 1.800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc2.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Aldeota</p>
                                            <p class="tamanh">86 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 2.300</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anuc3.jpg);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Planalto Ayrton Senna</p>
                                            <p class="tamanh">120 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anuc3.jpg);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Planalto Ayrton Senna</p>
                                            <p class="tamanh">120 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc2.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Aldeota</p>
                                            <p class="tamanh">86 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 2.300</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc1.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Jardim das Oliveiras</p>
                                            <p class="tamanh">100 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 1.800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anuc3.jpg);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Planalto Ayrton Senna</p>
                                            <p class="tamanh">120 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc1.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Jardim das Oliveiras</p>
                                            <p class="tamanh">100 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 1.800</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="cell-content">
                            <a href="anuncio">
                                <div class="zoom-image" style="background-image: url(source/img/anuncio/anunc2.webp);">
                                    <div class="infos">
                                        <div class="lado1">
                                            <p class="local">Aldeota</p>
                                            <p class="tamanh">86 m²</p>
                                        </div>
                                        <div class="lado2">
                                            <p class="valor"><b>R$ 2.300</b></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>