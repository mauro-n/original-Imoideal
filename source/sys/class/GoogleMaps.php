<?php

class GoogleMaps {

    private $apiKey;
    private $raio;

    public function __construct($raio = 1) {
        $this->apiKey = "AIzaSyDkV1zpoamsH6o8OSaQznGbnPECS6nwUpw";
        $this->raio = $raio * 1000;
    }

    public function WriteNearBy($lat, $log) {
        $tipos = [];
        $arr = [
            "key" => "hospital",
            "name" => "Hospital",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "school",
            "name" => "Escola",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "subway_station",
            "name" => "Metrô",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "supermarket",
            "name" => "Super Mercado",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "pharmacy",
            "name" => "Farmácia",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "bus_station",
            "name" => "Parada de Ônibus",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "gym",
            "name" => "Academia",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $arr = [
            "key" => "laundry",
            "name" => "Lavandeiria",
            "icon" => "",
        ];
        $tipos[] = $arr;

        $urlmain = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=";

        $html = "";
        $html .= "<ul class='list-group mt-1'>";
        foreach ($tipos as $tipo) {

            $url = $urlmain . $lat . "," . $log . "&radius=" . $this->raio . "&type=" . $tipo['key'] . "&key=" . $this->apiKey;
            $result = file_get_contents($url);
            $json = json_decode($result);

            if ($json->status == "OK") {
                $html .= '<li style="cursor: default;" class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#' . $tipo['key'] . 'List">';
                $html .= $tipo['name'];
                $html .= '<span class="badge bg-danger rounded-pill" aria-expanded="false" aria-controls="' . $tipo['key'] . 'List">##QNTS##</span>';
                $html .= '</li>';
                $html .= '<div class="collapse" id="' . $tipo['key'] . 'List">';
                $html .= '<ul class="list-group mt-0 mb-2">';
                $count = 0;
                foreach ($json->results as $place) {
                    if ($place->business_status == "OPERATIONAL") {
                        if (isset($place->user_ratings_total)) {
                            if (floatval($place->user_ratings_total) > floatval(5)) {
                                if (floatval($place->rating) > floatval(3)) {
                                    $count++;
                                    $html .= '<li class="list-group-item"><img class="me-2" src="' . $place->icon . '" width="20" alt="Local"/>' . $place->name . '</li>';
                                }
                            }
                        } else {
                            if ($tipo['key'] == "bus_station") {
                                $count++;
                                $html .= '<li class="list-group-item"><img class="me-2" src="' . $place->icon . '" width="20" alt="Local"/>' . $place->name . '</li>';
                            }
                        }
                    }
                }
                $html = str_replace("##QNTS##", $count, $html);
                $html .= '</ul>';
                $html .= '</div>';

//                echo "<pre>";
//                print_r($json->results);
//                echo "</pre>";
            }
        }
        $html .= "</ul>";

        return $html;
    }

}
