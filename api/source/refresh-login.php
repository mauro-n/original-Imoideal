<?php

header('Content-Type: application/json');
header('X-Powered-By: LDE Sistemas');

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('America/Fortaleza');

require_once '../sys/TokenAPI.php';
require_once '../sys/Database.php';
require_once '../sys/Usuario.php';

$tokenAPI = new TokenAPI();

try {
    $amb = $_GET['amb'];

    //Validação API Key
    if (isset($_SERVER['HTTP_API_KEY'])) {
        if (!$tokenAPI->ValidTokenAPI($_SERVER['HTTP_API_KEY'])) {
            throw new Exception("API-KEY é inválida");
        }
    } else {
        throw new Exception("API-KEY não definida");
    }
    
    //Validação Codigo Usuario
    if (isset($_GET['cod'])) {
        if (empty($_GET['cod']) || $_GET['cod'] == "") {
            throw new Exception("Código de usuário não definido");
        }
    } else {
        throw new Exception("Código de usuário não definido");
    }
    
    $cod = $_GET['cod'];

    $usuario = new Usuario($amb);
    $retorno = $usuario->GetUser($cod);
    if ($retorno['status']) {

        $return = [
            "userid" => $retorno['dados']['userid'],
            "urlimg" => $retorno['dados']['urlimg'],
            "email" => $retorno['dados']['email'],
            "nome" => $retorno['dados']['nome'],
            "telefone" => $retorno['dados']['telefone'],
            "plan" => $retorno['dados']['plan'],
            "status" => $retorno['dados']['status'],
            "checkwpp" => $retorno['dados']['checkwpp'],
            "resetpass" => $retorno['dados']['resetpass'],
            "datacriac" => $retorno['dados']['datacriac'],
            "dataedit" => $retorno['dados']['dataedit'],
        ];
    } else {
        throw new Exception($retorno['msglog']);
    }

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
