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

$tokenAPI = new TokenAPI();

try {

    //Validação API Key
    if (isset($_SERVER['HTTP_API_KEY'])) {
        if (!$tokenAPI->ValidTokenAPI($_SERVER['HTTP_API_KEY'])) {
            throw new Exception("API-KEY é inválida");
        }
    } else {
        throw new Exception("API-KEY não definida");
    }

    $return = [
        "categorias" => [],
        "tipos" => [],
    ];

    $categorias = [];
    $tipos = [];

    $conexao = Database::conexao('PRD');

    $consulta = $conexao->query("SELECT * FROM T_CATG_ANUNC WHERE CAT_STTS = 1;");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $line = [
            "id" => $linha['CAT_ICOD'],
            "descricao" => $linha['CAT_DESC'],
        ];
        $categorias[] = $line;
    }

    $consulta = $conexao->query("SELECT * FROM T_TYPE_ANUNC WHERE TYP_STTS = 1;");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $line = [
            "id" => $linha['TYP_ICOD'],
            "descricao" => $linha['TYP_DESC'],
        ];
        $tipos[] = $line;
    }

    $conexao = null;

    $return['categorias'] = $categorias;
    $return['tipos'] = $tipos;

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
