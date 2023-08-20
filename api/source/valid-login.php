<?php

header('Content-Type: application/json');
header('X-Powered-By: LDE Sistemas');

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('America/Fortaleza');

//Permissões
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: API-KEY, Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 86400");

require_once '../sys/TokenAPI.php';
require_once '../sys/Database.php';
require_once '../sys/Usuario.php';

$tokenAPI = new TokenAPI();

$input = [
    "email" => "",
    "pass" => "",
];

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

    // Decodifica o JSON enviado pelo curl
    $data = json_decode(file_get_contents('php://input'), true);

    //Validação Email
    if (isset($data['email'])) {
        $input['email'] = $data['email'];
    } else {
        throw new Exception("Parametro email não recebido");
    }

    //Validação Senha
    if (isset($data['pass'])) {
        $input['pass'] = $data['pass'];
    } else {
        throw new Exception("Parametro senha não recebido");
    }

    $usuario = new Usuario($amb);
    $retorno = $usuario->ValidLogin($input['email'], $input['pass']);
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
            "favoritos" => $retorno['dados']['favoritos'],
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
