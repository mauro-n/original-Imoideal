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

$input = [
    "userid" => 0,
    "postid" => 0,
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

    //Validação Usuario
    if (isset($data['userid'])) {
        $input['userid'] = $data['userid'];
    } else {
        throw new Exception("Parametro userid não recebido");
    }

    //Validação Anúncio
    if (isset($data['postid'])) {
        $input['postid'] = $data['postid'];
    } else {
        throw new Exception("Parametro postid não recebido");
    }

    $conexao = Database::conexao($amb);

    $sql = "SELECT COUNT(USR_ICOD) FROM T_USER WHERE USR_ICOD = '{$input['userid']}'";
    $stmt = $conexao->query($sql);
    if ($stmt->fetchColumn() == 0) {
        throw new Exception("Codigo de usuario é inválida");
    }

    $sql = "SELECT COUNT(ANC_ICOD) FROM T_ANUNCIO WHERE ANC_ICOD = '{$input['postid']}'";
    $stmt = $conexao->query($sql);
    if ($stmt->fetchColumn() == 0) {
        throw new Exception("Codigo de anúncio é inválida");
    }

    $sql = "SELECT COUNT(*) FROM T_FAVORITE WHERE FAV_USER = '{$input['userid']}' AND FAV_ANUC = '{$input['postid']}'";
    $stmt = $conexao->query($sql);
    if ($stmt->fetchColumn() != 0) {

        $sql = "DELETE FROM T_FAVORITE WHERE FAV_USER = :USER AND FAV_ANUC = :ANUC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute(array(
            ':USER' => $input['userid'],
            ':ANUC' => $input['postid'],
        ));
    }

    $conexao = null;

    $return = true;

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
