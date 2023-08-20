<?php

date_default_timezone_set('America/Fortaleza');

class Data {

    public function __construct() {
        
    }

    public function getTextDif($data) {

        $dataAtual = new DateTime(date('Y-m-d H:i:s'));
        $dataPostagem = new DateTime($data);

        $dif = date_diff($dataAtual, $dataPostagem);

        if ($dif->y <= 0) {
            if ($dif->m <= 0) {
                if ($dif->d <= 0) {
                    $text = "Hoje";
                } else {
                    if ($dif->d > 1) {
                        $text = "Há " . $dif->d . " dias";
                    } else {
                        $text = "Há " . $dif->d . " dia";
                    }
                }
            } else {
                if ($dif->m > 1) {
                    $text = "Há " . $dif->m . " meses";
                } else {
                    $text = "Há " . $dif->m . " mês";
                }
            }
        } else {
            if ($dif->y > 1) {
                $text = "Há " . $dif->y . " anos";
            } else {
                $text = "Há " . $dif->y . " ano";
            }
        }

        return $text;
    }

}
