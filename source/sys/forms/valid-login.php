<?php

require_once '../class/Token.php';

header("Content-Type: application/json");

$retorno = [
    "status" => false,
    "mensagem" => ""
];

try {

    $tokenAPI = new Token();

    $ch = curl_init();

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Api-Key: ' . $tokenAPI->getToken();
    $headers[] = 'Content-Type: application/json';

    if (!isset($_POST['email'])) {
        throw new Exception("Parametro e-mail não informado");
    }

    if (!isset($_POST['senha'])) {
        throw new Exception("Parametro senha não informado");
    }

    $fields = array(
        "email" => $_POST['email'],
        "pass" => $_POST['senha'],
    );

    curl_setopt($ch, CURLOPT_URL, 'https://api.imoideal.com/source/prd/valid-login');
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

    if (isset($json->userid)) {
        $retorno['status'] = true;
        $retorno['mensagem'] = "Logado com sucesso!";

        $array = [
            "userid" => $json->userid,
            "urlimg" => $json->urlimg,
            "email" => $json->email,
            "nome" => $json->nome,
            "telefone" => $json->telefone,
            "plan" => $json->plan,
            "status" => $json->status,
            "checkwpp" => $json->checkwpp,
            "resetpass" => $json->resetpass,
            "datacriac" => $json->datacriac,
            "dataedit" => $json->dataedit
        ];

        session_start();
        $_SESSION['USER'] = $array;
        
    } else {
        throw new Exception($json->error_message);
    }
} catch (Exception $exc) {
    $retorno['status'] = false;
    $retorno['mensagem'] = $json->error_message;
}

echo json_encode($retorno, JSON_PRETTY_PRINT);

