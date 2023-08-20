<?php
require_once './source/sys/class/Token.php';
require_once './source/sys/class/Session.php';
require_once './source/sys/class/Container.php';

$session = new Session();
$session->ValidSession();
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

//Limpar Pasta Temp
$path = "files/temp/uploads/" . $_SESSION['USER']['userid'];
if (file_exists($path)) {
    $arquivos = scandir($path);
    foreach ($arquivos as $arquivo) {
        if ($arquivo != "." && $arquivo != "..") {
            unlink($path . "/" . $arquivo);
        }
    }
    rmdir($path);
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Novo Anúncio - ImoIdeal</title>
        <meta name='title' content='Novo Anúncio - ImoIdeal'>
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
        <script src="source/js/newpost.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/default.css">
        <link rel="stylesheet" type="text/css" href="source/css/newpost.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">

    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container mb-4" style="min-height: 400px;">
            <h5 class="w-100 text-center mt-4 mb-4">Novo Anúncio</h5>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <div class="row">
                                <div class="col-md text-center mb-0">
                                    <p class="p m-0" style="font-size: 0.9em;"><small><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i></small><small class="text-muted">Sua primeira imagem será a capa do anúncio.</small></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mb-2">
                                    <hr>
                                    <div class="m-0 w-100" id="list-imgs">
                                        <p class="p m-0 w-100 text-center" style="font-size: 0.9em;"><small class="text-muted">Sem imagens</small></p>
                                    </div>
                                    <hr>
                                    <hr>
                                    <input type="file" onchange="OnchangeFile(this);" class="hidden" id="fileInput" accept="image/*" multiple>
                                    <div class="card mt-3" onclick="ImportImg();" style="cursor: pointer;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-muted m-0"><i class="fa-solid fa-upload me-2"></i>Adicionar Imagem</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInputValue" placeholder="Insira o Titulo">
                                <label for="floatingInputValue" class="text-muted">Título</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" style="height: 200px;resize: none;" placeholder="Escreva a descrição" id="floatingTextarea"></textarea>
                                <label for="floatingTextarea" class="text-muted">Descrição</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInputValue" placeholder="Endereço">
                                <label for="floatingTextarea" class="text-muted">Endereço</label>
                            </div>
                            <div class="row">
                                <div class="col-md mb-3">
                                    <div class="form-floating">
                                        <select id="PesqCateg" class="form-select">
                                            <?php
                                            foreach ($categorias as $cat) {
                                                echo "<option value='" . $cat->id . "'>" . $cat->descricao . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Categ. do anúncio</label>
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <div class="form-floating">
                                        <select id="PesqType" class="form-select">
                                            <?php
                                            foreach ($tipos as $tip) {
                                                echo "<option value='" . $tip->id . "'>" . $tip->descricao . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Tipo do anúncio</label>
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><small class="text-muted">R$</small></span>
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="RegisterTel" autocomplete="off" placeholder="0">
                                            <label for="RegisterTel" class="text-muted">Valor</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingInputValue" placeholder="0">
                                        <label for="floatingInputValue" class="text-muted">Quartos</label>
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingInputValue" placeholder="0">
                                        <label for="floatingInputValue" class="text-muted">Banheiros</label>
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingInputValue" placeholder="0">
                                        <label for="floatingInputValue" class="text-muted">Vagas</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mb-3" style="margin-top: -15px;">
                                    <div class="extra-container m-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckEXTA">
                                            <label class="form-check-label" for="CheckEXTA">
                                                Área externa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckPSCN">
                                            <label class="form-check-label" for="CheckPSCN">
                                                Piscina
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckARLZ">
                                            <label class="form-check-label" for="CheckARLZ">
                                                Área de lazer
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-2">
                            <button type="button" class="btn btn-danger w-100"><i class="fa-solid fa-floppy-disk me-2"></i>Salvar</button>
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