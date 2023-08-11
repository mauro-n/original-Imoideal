<?php

$apiKey = "AIzaSyDkV1zpoamsH6o8OSaQznGbnPECS6nwUpw";

$retorno = [];

try {
    if (!isset($_POST['search'])) {
        throw new Exception("Vazio");
    }
    
    $searchText = $_POST['search'];
    $encodedSearchText = urlencode($searchText);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $encodedSearchText . "&language=pt-BR&key=" . $apiKey;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    $json = json_decode($result);

    if ($json->status === "OK") {
        $results = $json->results;

//        echo "<pre>";
//        print_r($results);
//        echo "</pre>";

        foreach ($results as $result) {
            
            $success = false;

            $array = [
                "text" => "",
                "type" => 0
            ];

            $array["text"] = $result->formatted_address;

            foreach ($result->types as $type) {
                $find = false;
                switch ($type) {
                    case "route":
                        $array["type"] = 1;
                        $find = true;
                        $success = true;
                        break;
                    case "sublocality":
                        $array["type"] = 2;
                        $find = true;
                        $success = true;
                        break;
                    case "administrative_area_level_2":
                        $array["type"] = 3;
                        $find = true;
                        $success = true;
                        break;
                    case "administrative_area_level_1":
                        $array["type"] = 4;
                        $find = true;
                        $success = true;
                        break;
                    default:
                        break;
                }
                if ($find) {
                    break;
                }
            }
            
            if ($success) {
                $retorno[] = $array;
            }
        }
    } else {
        throw new Exception("Erro na busca.");
    }
} catch (Exception $exc) {
    
}

echo json_encode($retorno, JSON_PRETTY_PRINT);
