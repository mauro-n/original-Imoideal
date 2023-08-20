<?php
require_once 'source/sys/class/Token.php';
require_once 'source/sys/class/Container.php';
require_once 'source/sys/class/Session.php';
require_once 'source/sys/class/Data.php';

$session = new Session();
$session->RefreshSession();

$path = "";
if (isset($_GET['filtro'])) {
    $path = "../";
} else {
    $path = "";

    //Se não tiver filtro voltar pro Index
    header("Location: ./");
    exit();
}

$FilCatg;
$FilType;
$FilText;
$FilMod;

$anuncios = [];

$fields = explode("$$$", base64_decode($_GET['filtro']));

foreach ($fields as $field) {
    $campo = explode("###", $field);
    switch ($campo[0]) {
        case "catg":
            $FilCatg = $campo[1];
            break;
        case "type":
            $FilType = $campo[1];
            break;
        case "text":
            $FilText = $campo[1];
            break;
        case "mod":
            $FilMod = $campo[1];
            break;
    }
}

if (empty($FilCatg) || empty($FilType) || empty($FilText)) {
    header("Location: ./");
    exit();
}

$html = new Container($path);

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

    $type_f = intval($FilMod - 1);

    if ($type_f < 1) {
        //Requisão do tipo do novo endereço
        $arr = [
            "search" => $FilText
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://imoideal.com/source/sys/forms/endereco.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $json = json_decode($result);

        if (!empty($json)) {
            $FilText = $json[0]->text;
            $FilMod = $json[0]->type;
            $type_f = intval($FilMod - 1);
        }
    }

    $filtro = [
        "catg_a" => $FilCatg,
        "type_a" => $FilType,
        "type_f" => $type_f,
        "text" => $FilText
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.imoideal.com/source/prd/list-posts');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($filtro));
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
    //header("Location: {$path}500.php");
    echo $e->getMessage();
    exit;
}
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
        <script src="<?php echo $path; ?>source/js/windowmsg.js"></script>
        <script src="<?php echo $path; ?>source/js/openlink.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/default.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/pesquisa.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/rodape.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo $path; ?>source/js/pesquisa.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>source/js/filtros.js"></script>
    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container">
            <div class="box-search">
                <form class="form-search">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <select id="PesqCateg" class="form-select">
                                <?php
                                foreach ($categorias as $cat) {
                                    if (intval($FilCatg) == $cat->id) {
                                        echo "<option value='" . $cat->id . "' selected>" . $cat->descricao . "</option>";
                                    } else {
                                        echo "<option value='" . $cat->id . "'>" . $cat->descricao . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select id="PesqType" class="form-select">
                                <?php
                                foreach ($tipos as $tip) {
                                    if (intval($FilType) == $tip->id) {
                                        echo "<option value='" . $tip->id . "' selected>" . $tip->descricao . "</option>";
                                    } else {
                                        echo "<option value='" . $tip->id . "'>" . $tip->descricao . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md mb-2" id="opt-containe">
                            <input type="text" id="PesqText" class="form-control" oninput="OnWriting(this);" placeholder="Local" value="<?php echo $FilText; ?>" aria-label="Local" autocomplete="off">
                            <div class="options-container noshow" id="options-container">
                            </div>
                        </div>
                        <div class="col-md-2  mb-2">
                            <button id="btnpesq" type="button" onclick="Pesquisar(<?php echo $FilMod; ?>);" style="width: 100%;" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass me-2"></i>Pesquisar</button>
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
                            <p class="card-text w-100 m-0 mb-1">Ordem</p>
                            <select id="FiltOrd" class="form-select form-select-sm">
                                <option value="0">Relevância</option>
                                <option value="1">Data</option>
                                <option value="2">Mais Barato (0-9)</option>
                                <option value="3">Mais Caro (9-0)</option>
                            </select>
                            <hr>
                            <p class="card-text w-100 m-0 mb-1">Quartos</p>
                            <div class="input-group mb-2">
                                <select id="FiltQuat" class="form-select form-select-sm">
                                    <option value="">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5 ou mais</option>
                                </select>
                            </div>
                            <hr>
                            <p class="card-text w-100 m-0 mb-1">Metros</p>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">De&nbsp;&nbsp;<small class="text-muted">(m²)</small></span>
                                <input type="number" class="form-control" id="FiltMetrMin" name="minPrice">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Até&nbsp;<small class="text-muted">(m²)</small></span>
                                <input type="number" class="form-control" id="FiltMetrMax" name="maxPrice">
                            </div>
                            <hr>
                            <p class="card-text w-100 m-0 mb-1">Faixa de Preço</p>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">De&nbsp;&nbsp;<small class="text-muted">(R$)</small></span>
                                <input type="number" class="form-control" id="FiltPrecMin" name="minPrice">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Até&nbsp;<small class="text-muted">(R$)</small></span>
                                <input type="number" class="form-control" id="FiltPrecMax" name="maxPrice">
                            </div>
                            <hr>
                            <button onclick="Filtrar();" type="button" class="btn w-100 btn-outline-light"><i class="fa-solid fa-magnifying-glass me-2"></i>Filtrar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md mb-4">
                    <div id="list-anuncios">
                        <?php
                        
                        $data = new Data();

                        if (!empty($anuncios)) {
                            foreach ($anuncios as $a) {
                                echo "<div id='" . $a->codigo . "' price='" . $a->price . "' data='" . $a->data . "' ponto='" . $a->pontos . "' onclick=\"AbrirLink('../anuncio/" . $a->codigo . "');\" class='card anunc w-100 mb-4'>";
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
                    <hr>
                    <ul id="list-btns-page" class="pagination justify-content-center">

                    </ul>
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