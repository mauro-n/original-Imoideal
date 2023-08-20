<?php
require_once './source/sys/class/Token.php';
require_once './source/sys/class/Container.php';
require_once './source/sys/class/Session.php';

$session = new Session();
$session->RefreshSession();

$html = new Container();

try {

    $tokenAPI = new Token();

    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $tokenAPI->getToken();
    $headers[] = 'Content-Type: application/json';

    curl_setopt($ch, CURLOPT_URL, 'https://api.imoideal.com/source/prd/info-system');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    $json = json_decode($result);

    if (isset($json->error_message)) {
        throw new Exception($json->error_message);
    }

    $categorias = $json->categorias;
    $tipos = $json->tipos;
} catch (Exception $e) {

    header("Location: 500.php");
    exit;
}
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
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="source/js/windowmsg.js"></script>
        <script src="source/js/openlink.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/default.css">
        <link rel="stylesheet" type="text/css" href="source/css/index.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">

        <script type="text/javascript" src="source/js/pesquisa.js"></script>

    </head>
    <body>
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
                                    <?php
                                    foreach ($categorias as $cat) {
                                        echo "<option value='" . $cat->id . "'>" . $cat->descricao . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select id="PesqType" class="form-select">
                                    <?php
                                    foreach ($tipos as $tip) {
                                        echo "<option value='" . $tip->id . "'>" . $tip->descricao . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md mb-2" id="opt-containe">
                                <input type="text" id="PesqText" class="form-control" oninput="OnWriting(this);" placeholder="Local" aria-label="Local" autocomplete="off">
                                <div class="options-container noshow" id="options-container">
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <button id="btnpesq" type="button" onclick="Pesquisar();" style="width: 100%;" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass me-2"></i>Pesquisar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container principal" style="min-height: 200px;">
            <h3>Anúncios destacados</h3>
            <div class="container" id="highlights">
                <div class="text-center">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <script>
            function getCityFromIP() {
                const apiUrl = 'https://ipinfo.io?token=ae250d4afdb5ad';
                fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            const city = data.city; // A cidade do usuário
                            document.getElementById("PesqText").value = city;
                            GetListHighLights(city);
                            console.log(`Você está na cidade de ${city}`);
                        })
                        .catch(error => {
                            console.error('Erro ao obter informações de localização:', error);
                        });
            }

            function GetListHighLights(city) {
                const url = 'https://api.imoideal.com/source/prd/list-highlights/' + encodeURIComponent(city);
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'accept': 'application/json',
                        'API-KEY': ''
                    }
                })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            MontarAnuncios(data);
                        })
                        .catch(error => {
                            console.error('Ocorreu um erro:', error);
                        });

            }

            function MontarAnuncios(anuncios) {
                let ancdiv = document.getElementById("highlights");

                let count = 0;
                let html = '';

                if (anuncios.length === 0) {
                    html += "<p class='w-100 text-center text-muted'>Sem anúncios destacados na sua cidade</p>";
                } else {
                    anuncios.forEach(a => {
                        count++;
                        if (count === 1) {
                            html += "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>";
                        }

                        html += "<div class='col'>";
                        html += "<div class='cell-content'>";
                        html += "<div onclick=\"AbrirLink('anuncio/" + a.codigo + "');\" class='zoom-image' style='background-image: url(" + a.imagens[0] + ");'>";
                        html += "<div class='infos'>";
                        html += "<div class='lado1'>";
                        html += "<p class='local'>" + a.title + "</p>";
                        html += "<p class='tamanh'>100 m²</p>";
                        html += "</div>";
                        html += "<div class='lado2'>";
                        html += "<p class='valor'><b>R$ " + a.price + "</b></p>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";

                        if (count === 3) {
                            count = 0;
                            html += "</div>";
                        }
                    });

                    switch (count) {
                        case 1:
                        case 2:
                            html

                    }
                }
                
                ancdiv.innerHTML = html;
            }

            getCityFromIP();
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>