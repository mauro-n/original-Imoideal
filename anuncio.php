<?php
require_once 'source/sys/class/Token.php';
require_once 'source/sys/class/Container.php';
require_once 'source/sys/class/Session.php';
require_once 'source/sys/class/Data.php';
require_once 'source/sys/class/GoogleMaps.php';

$session = new Session();
$session->RefreshSession();

$path = "";
if (isset($_GET['cod'])) {
    $path = "../";
} else {
    $path = "";

    //Se não tiver filtro voltar pro Index
    header("Location: ./");
    exit();
}

$html = new Container($path);
$data = new Data();

try {

    $tokenAPI = new Token();

    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $tokenAPI->getToken();
    $headers[] = 'Content-Type: application/json';

    $url = "https://api.imoideal.com/source/prd/get-post/" . $_GET['cod'];

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

    $anuncio = $json;
} catch (Exception $e) {
    header("Location: {$path}500.php");
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
        echo $html->WriteSEO("Imoideal - " . $anuncio->title, $anuncio->descricao, "");
        ?>

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
        <script src="<?php echo $path; ?>source/js/googlemaps.js"></script>
        <script src="<?php echo $path; ?>source/js/anuncio.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/default.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/anuncio.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>source/css/rodape.css">
        <script type="text/javascript">
            const idimg = "img-anunc-main";
            const mdimg = "img-modal-anunc";
            function OpenImg(obj) {
                try {
                    const image = obj.style.backgroundImage;
                    const imageUrl = image.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
                    console.log(imageUrl);
                    document.getElementById(mdimg).src = imageUrl;
                    $('#ModalImg').modal('show');
                } catch (e) {
                    alert("Erro ao exibir Imagem");
                }
            }
            function changeImg(obj) {
                const image = obj.style.backgroundImage;
                const imageUrl = image.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
                console.log(imageUrl);
                document.getElementById(idimg).style.backgroundImage = "url(" + imageUrl + ")";
                document.getElementById(mdimg).src = imageUrl;
            }
        </script>
    </head>
    <body>
        <?php
        echo $html->WriteMenu();
        ?>

        <hr class="divisa">

        <div class="container">
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <?php
                        echo "<div class='img-anuncio' id='img-anunc-main' onclick='OpenImg(this);' style='background-image: url(" . $anuncio->imagens[0] . ");'></div>";
                        ?>
                        <div class="line-img">
                            <?php
                            foreach ($anuncio->imagens as $img) {
                                echo "<div class='img' onclick='changeImg(this);' style='background-image: url(" . $img . ");'></div>";
                            }
                            ?>
                        </div>
                        <h1 class="title-anun"><?php echo $anuncio->title; ?> <small class="text-muted">(R$ <?php echo $anuncio->price; ?>)</small></h1>
                        <h2 class="endre-anun mb-1" style="cursor: default;"><i class="fa-solid fa-location-dot text-muted me-2"></i><?php echo $anuncio->address; ?></h2>
                        <p class="w-100 m-0 text-muted"><small><small><?php echo $data->getTextDif($anuncio->data); ?></small></small></p>
                        <hr class="mt-2">
                        <h5>Descrição</h5>
                        <p><?php echo $anuncio->descricao; ?></p>
                        <hr>
                        <h5>Mapa <small class="text-muted">(Localização)</small></h5>
                        <div id="map"></div>
                        <h5 class="mt-4">Pontos próximos <small class="text-muted">(3km)</small></h5>
                        <?php
                        $googleMaps = new GoogleMaps(3);
                        echo $googleMaps->WriteNearBy($anuncio->lat, $anuncio->log);
                        ?>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="<?php echo $anuncio->user->img; ?>" class="profile-picture" alt="Foto do Anunciante">
                                <div class="info-user">
                                    <h5 class="card-title"><?php echo $anuncio->user->nome; ?></h5>
                                    <p class="card-text">+55 <?php echo $anuncio->user->tel; ?></p>
                                </div>
                                <hr>
                                <p class="card-text mb-1"><b>Características</b></p>
                                <div class="w-100 mb-2">
                                    <?php
                                    echo "<span class='badge rounded-pill text-bg-secondary me-1'>" . $anuncio->quartos . " Quartos</span>";
                                    echo "<span class='badge rounded-pill text-bg-secondary me-1'>" . $anuncio->banheiros . " Banheiros</span>";
                                    echo "<span class='badge rounded-pill text-bg-secondary me-1'>" . $anuncio->metros . " m²</span>";
                                    if ($anuncio->vagas > 0) {
                                        echo "<span class='badge rounded-pill text-bg-secondary me-1'>" . $anuncio->vagas . " Vagas</span>";
                                    }
                                    if ($anuncio->areaext) {
                                        echo "<span class='badge rounded-pill text-bg-secondary me-1'>Área externa</span>";
                                    }
                                    if ($anuncio->piscina) {
                                        echo "<span class='badge rounded-pill text-bg-secondary me-1'>Piscina</span>";
                                    }
                                    if ($anuncio->arealzr) {
                                        echo "<span class='badge rounded-pill text-bg-secondary me-1'>Área de lazer</span>";
                                    }
                                    ?>
                                </div>
                                <hr>
                                <p class="card-text mb-1"><b>Condições</b></p>
                                <div class="w-100 mb-2">
                                    <p class="w-100 m-0 text-muted"><small>Texto</small></p>
                                </div>
                                <hr>
                                <?php
                                echo $session->writeBtnFat($anuncio->codigo);
                                ?>
                                <a href="https://api.whatsapp.com/send?phone=55<?php echo $anuncio->user->tel; ?>&text=Ol%C3%A1%2C+vi+seu+an%C3%BAncio+no+Imodeal.%0ATenho+interesse%2C+ainda+est%C3%A1+dispon%C3%ADvel%3F" target="_blank" class="w-100 btn btn-danger"><i class="fa-brands fa-whatsapp me-2"></i>Enviar Mensagem</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        echo $html->WriteRodape();
        ?>

        <a class="btnswpp" href="https://api.whatsapp.com/send?phone=55<?php echo $anuncio->user->tel; ?>&text=Ol%C3%A1%2C+vi+seu+an%C3%BAncio+no+Imodeal.%0ATenho+interesse%2C+ainda+est%C3%A1+dispon%C3%ADvel%3F" target="_blank">
            <img src="https://imoideal.com/files/whatsapp-icon.png" width="60" height="60" alt="WhatsApp"/>
        </a>

        <!-- Modal View Img -->
        <div class="modal fade" id="ModalImg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content" >
                    <img class="img-modal" id="img-modal-anunc" src=""/>
                    <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function initMap() {

                const location = {
                    lat: <?php echo $anuncio->lat; ?>,
                    lng: <?php echo $anuncio->log; ?>
                };

                console.log(location);

                const map = new google.maps.Map(document.getElementById("map"), {
                    center: location,
                    zoom: 15,
                    gestureHandling: 'none',
                });

                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: {
                        url: 'https://imoideal.com/files/logo-app_50.png',
                        scaledSize: new google.maps.Size(35, 35),
                    },
                    title: "Localização do Imóvel",
                    clickable: true,
                    draggable: false,
                });

                marker.addListener('click', function () {
                    var end = "<?php echo str_replace(" ", "+", $anuncio->address); ?>";
                    var url = 'https://www.google.com.br/maps/place/' + end;
                    window.open(url, '_blank');
                });
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>