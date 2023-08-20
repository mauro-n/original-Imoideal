<?php

$GoogleApiKey = "AIzaSyDkV1zpoamsH6o8OSaQznGbnPECS6nwUpw";
$linkApi = "https://maps.googleapis.com/maps/api/geocode/json?address=";

//Processar FILTROS dos ANUNCIOS
require_once 'api/sys/Database.php';

$anuncios = [];

$conexao = Database::conexao('PRD');

$consulta = $conexao->query("SELECT * FROM T_ANUNCIO WHERE ANC_JBPC = 0;");
while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $anuncios[] = $linha;
}

foreach ($anuncios as $anuncio) {

    $rua = "";
    $bairro = "";
    $cidade = "";
    $estado = "";

    $encodedSearchText = urlencode($anuncio['ANC_ADRS']);
    $url = $linkApi . $encodedSearchText . "&language=pt-BR&key=" . $GoogleApiKey;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        continue;
    }
    curl_close($ch);

    $json = json_decode($result);

    if ($json->status === "OK") {

        $results = $json->results;

        if (isset($results[0]->address_components)) {
            $result = $results[0]->address_components;

            foreach ($result as $line) {
//                echo "<pre>";
//                print_r($line);
//                echo "</pre>";

                foreach ($line->types as $l) {
                    switch ($l) {
                        case "route":
                            $rua = $line->short_name;
                            break;
                        case "sublocality":
                            $bairro = $line->short_name;
                            break;
                        case "administrative_area_level_2":
                            $cidade = $line->short_name;
                            break;
                        case "administrative_area_level_1":
                            $estado = $line->short_name;
                            break;
                    }
                }
            }

            $sql = "UPDATE T_ANUNCIO SET ANC_STRT = :STRT, ANC_BAIR = :BAIR, ANC_CITY = :CITY, ANC_UFST = :UFST, ANC_JBPC = :JBPC WHERE ANC_ICOD = :ICOD";
            $stmt = $conexao->prepare($sql);
            $stmt->execute(array(
                ':STRT' => $rua,
                ':BAIR' => $bairro,
                ':CITY' => $cidade,
                ':UFST' => $estado,
                ':JBPC' => 1,
                ':ICOD' => $anuncio['ANC_ICOD'],
            ));
        } else {
            continue;
        }
    } else {
        continue;
    }
}

$conexao = null;
?>
