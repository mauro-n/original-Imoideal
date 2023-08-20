<?php
require_once 'source/sys/class/Token.php';
require_once 'source/sys/class/Session.php';
require_once 'source/sys/class/Container.php';
require_once 'source/sys/class/Data.php';

$session = new Session();
$session->ValidSession();
$session->RefreshSession();

$html = new Container();

$anuncios = [];

try {

    $tokenAPI = new Token();

    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $tokenAPI->getToken();
    $headers[] = 'Content-Type: application/json';

    $url = "https://api.imoideal.com/source/prd/get-likes/" . $_SESSION['USER']['userid'];

    curl_setopt($ch, CURLOPT_URL, $url);
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

    $anuncios = $json;
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

        <title>Favoritos - ImoIdeal</title>
        <meta name='title' content='Favoritos - ImoIdeal'>
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
        <script src="source/js/windowmsg.js"></script>
        <script src="source/js/openlink.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/default.css">
        <link rel="stylesheet" type="text/css" href="source/css/favoritos.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">

    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container" style="min-height: 400px;">
            <h5 class="w-100 text-center mt-4 mb-4">Favoritos</h5>
            <div class="row anuclinks">
                <div class="col-md mb-4">
                    <?php
                    
                    $data = new Data();
                    
                    if (empty($anuncios)) {
                        echo "<h5 class='w-100 text-center text-muted'>(Não há anúncio salvos)</h5>";
                    } else {
                        foreach ($anuncios as $a) {
                            echo "<div onclick=\"AbrirLink('anuncio/" . $a->codigo . "');\" class='card anunc w-100 mb-4'>";
                            echo "<div class='card-body'>";
                            echo "<div class='row'>";
                            echo "<div class='col-sm-4'>";
                            echo "<div class='img-anuncio' style='background-image: url(" . $a->imagens[0] . ");'></div>";
                            echo "</div>";
                            echo "<div class='col-sm title-anun'>";
                            echo "<h5 class='card-title mb-1'>" . $a->title . "</h5>";
                            echo "<p class='card-text mb-1 text-muted'><small>" . $a->address . "</small></p>";
                            echo "<div class='w-100'>";
                            echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>" . $a->quartos . " Quartos</span>";
                            echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>" . $a->banheiros . " Banheiros</span>";
                            echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>" . $a->metros . " m²</span>";
                            if ($a->vagas > 0) {
                                echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>" . $a->vagas . " Vagas</span>";
                            }
                            if ($a->areaext) {
                                echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>Área externa</span>";
                            }
                            if ($a->piscina) {
                                echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>Piscina</span>";
                            }
                            if ($a->arealzr) {
                                echo "<span class='badge rounded-pill text-bg-secondary me-1 mb-1'>Área de lazer</span>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='col-sm-2 prec-anun text-end'>";
                            $vlr = explode(".", $a->price);
                            echo "<h5 class='card-title m-0'>R$ " . $vlr[0] . "<small><small class='text-muted'>/mês</small></small></h5>";
                            echo "<p class='time-anun w-100 m-0 text-muted'><small>" . $data->getTextDif($a->data) . "</small></hp>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>