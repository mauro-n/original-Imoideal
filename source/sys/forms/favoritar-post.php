<?php

require_once '../class/Token.php';

header("Content-Type: application/json");

$retorno = [
    "status" => false,
    "mensagem" => "",
    "post" => ""
];

try {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['USER']['userid'])) {
        throw new Exception("Usuario não está logado");
    }

    $tokenAPI = new Token();

    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $tokenAPI->getToken();
    $headers[] = 'Content-Type: application/json';

    if (!isset($_POST['save'])) {
        throw new Exception("Parametro save não informado");
    }

    if (!isset($_POST['postid'])) {
        throw new Exception("Parametro postid não informado");
    }

    $fields = array(
        "userid" => $_SESSION['USER']['userid'],
        "postid" => $_POST['postid'],
    );

    if (boolval($_POST['save'])) {
        curl_setopt($ch, CURLOPT_URL, 'https://api.imoideal.com/source/prd/like-post');
    } else {
        curl_setopt($ch, CURLOPT_URL, 'https://api.imoideal.com/source/prd/unlike-post');
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    $json = json_decode($result);

    if (isset($json->error_message)) {
        throw new Exception($json->error_message);
    } else {
        $retorno['status'] = true;
        $retorno['mensagem'] = "Sucesso!";
        $retorno['post'] = $_POST['save'];
    }
} catch (Exception $exc) {
    $retorno['status'] = false;
    $retorno['mensagem'] = $exc->getMessage();
}

echo json_encode($retorno, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

