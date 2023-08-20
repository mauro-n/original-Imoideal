<?php
try {
    $apitoken = "s@4FmN!!QK92ZytCKNGn4gdmG^co9r%N5M7aZ9AM%i93^baYUg";
    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $apitoken;
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
} catch (Exception $exc) {
    echo $exc->getMessage();
    exit();
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Importador</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="index.css">
    </head>
    <body>

        <div class="container" style="min-height: 500px;">
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
                                    <!--<p class="p m-0 w-100 text-center" style="font-size: 0.9em;"><small class="text-muted">Sem imagens</small></p>-->
                                    <div class="img-aded mb-1" style="background-image: url(../source/img/anuncio/anunc1.webp);">
                                        <p>nome do arquivo.png</p>
                                        <button type="button" class="close-btn">&times;</button>
                                    </div>
                                    <div class="img-aded mb-1" style="background-image: url(../source/img/anuncio/anunc2.webp);">
                                        <p>nome do arquivo meio peq.png</p>
                                        <button type="button" class="close-btn">&times;</button>
                                    </div>
                                    <div class="img-aded mb-1" style="background-image: url(../source/img/anuncio/anuc3.jpg);">
                                        <p>nome do arquivo muito grande com espa asdadadasdasdsa dsa.png</p>
                                        <button type="button" class="close-btn">&times;</button>
                                    </div>
                                    <hr>
                                    <div class="card mt-3" style="cursor: pointer;">
                                        <div class="card-body">
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>