<?php
require_once './source/sys/class/Container.php';

$html = new Container();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- SEO -->
        <?php
        echo $html->WriteSEO("Imoideal - Titulo anuncio", "descrição anuncio", "tags");
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="source/css/anuncio.css">
        <link rel="stylesheet" type="text/css" href="source/css/rodape.css">
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
                        <div class="img-anuncio" id="img-anunc-main" onclick="OpenImg(this);" style="background-image: url(source/img/anuncio/anunc2.webp);"></div>
                        <div class="line-img">
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc2.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc1.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anuc3.jpg);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc2.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc1.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anuc3.jpg);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc2.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc1.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anuc3.jpg);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc2.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anunc1.webp);"></div>
                            <div class="img" onclick="changeImg(this);" style="background-image: url(source/img/anuncio/anuc3.jpg);"></div>
                        </div>
                        <h1 class="title-anun">Titulo do Anuncio <small class="text-muted">(R$ 1.800)</small></h1>
                        <h2 class="endre-anun"><i class="fa-solid fa-location-dot text-muted"></i> Rua Monsenhor João Luis Santiago, 647 - Jardim das Oliveiras - Fortaleza - CE</h2>
                        <hr>
                        <h5>Descrição</h5>
                        <p>Casa recem construida, otima localização, execelente para um casal com uma criança</p>
                        <hr>
                        <h5>Mapa <small class="text-muted">(Localização)</small></h5>
                        <div id="map"></div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs2MvmzH1dPt-PEa5eMZtAhrQ8MkX3C91uUw&usqp=CAU" class="profile-picture" alt="Foto do Anunciante">
                                <div class="info-user">
                                    <h5 class="card-title">Nome do Anunciante</h5>
                                    <p class="card-text">+55 (11) 9 8765-4321</p>
                                </div>
                                <hr>
                                <p class="card-text mb-1"><b>Características</b></p>
                                <div class="w-100 mb-2">
                                    <span class="badge rounded-pill text-bg-secondary">Chuveiro Eletrico</span>
                                    <span class="badge rounded-pill text-bg-secondary">Churrasqueira</span>
                                    <span class="badge rounded-pill text-bg-secondary">2 Quartos</span>
                                    <span class="badge rounded-pill text-bg-secondary">1 Suite</span>
                                    <span class="badge rounded-pill text-bg-secondary">Mobiliado</span>
                                    <span class="badge rounded-pill text-bg-secondary">Sem Fiador</span>
                                </div>
                                <hr>
                                <p class="card-text mb-1"><b>Condições</b></p>
                                <div class="w-100 mb-2">
                                    <span class="badge rounded-pill text-bg-secondary">2 Cauções</span>
                                    <span class="badge rounded-pill text-bg-secondary">Fiador</span>
                                    <span class="badge rounded-pill text-bg-secondary">Renda Minima R$2.000</span>
                                </div>
                                <hr>
                                <button type="button" class="w-100 btn btn-outline-danger mb-2"><i class="fa-regular fa-bookmark"></i> Salvar</button>
                                <!--<button type="button" class="w-100 btn btn-outline-danger mb-2"><i class="fa-solid fa-xmark"></i> Remover Favoritos</button>-->
                                <button type="button" class="w-100 btn btn-danger">Enviar Mensagem</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        echo $html->WriteRodape();
        ?>

        <!-- Modal View Img -->
        <div class="modal fade" id="ModalImg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content" >
                    <img class="img-modal" id="img-modal-anunc" src="source/img/anuncio/anunc1.webp"/>
                    <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function initMap() {
                const location = {lat: -3.9092674, lng: -38.4536775}; // Coordenadas do imóvel (latitude e longitude)
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: location,
                    zoom: 15, // Zoom inicial do mapa (1 = mundo, 20 = rua)
                });

                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: "Localização do Imóvel",
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCE5o0AtJCU0I5WeJY1xtbJ_ALt3cle8No&callback=initMap"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>