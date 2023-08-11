<?php

require_once 'Token.php';

class Session {

    public function __construct() {
        
    }

    public function ValidSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['USER'])) {
            session_destroy();
            header("Location: ./");
            exit();
        }
    }

    public function RefreshSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['USER'])) {

            try {

                $tokenAPI = new Token();

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Api-Key: ' . $tokenAPI->getToken();

                $url = "https://api.imoideal.com/source/prd/refresh-login/" . $_SESSION['USER']['userid'];

                $ch = curl_init();

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

                if (isset($json->userid)) {
                    
                    $_SESSION['USER']['urlimg'] = $json->urlimg;
                    $_SESSION['USER']['email'] = $json->email;
                    $_SESSION['USER']['nome'] = $json->nome;
                    $_SESSION['USER']['telefone'] = $json->telefone;
                    $_SESSION['USER']['plan'] = $json->plan;
                    $_SESSION['USER']['status'] = $json->status;
                    $_SESSION['USER']['checkwpp'] = $json->checkwpp;
                    $_SESSION['USER']['resetpass'] = $json->resetpass;
                    $_SESSION['USER']['datacriac'] = $json->datacriac;
                    $_SESSION['USER']['dataedit'] = $json->dataedit;
                    
                }
                
            } catch (Exception $exc) {
                //Fazer nada
                echo $exc->getMessage() . " => Session->RefreshSession()";
            }
        }
    }

}
