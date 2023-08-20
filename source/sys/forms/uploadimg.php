<?php

$diretorio = '../../../files/temp/uploads/';

$uploadOk = true;
$return = [];
$files = [];

try {

    //Valida a sessão
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['USER']['userid'])) {
        throw new Exception("Usuario não está logado");
    }
    
    //Recupera o ID do usuario
    $usuario = $_SESSION['USER']['userid'] . "/";

    //Verifica se a conexão é via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de envio inválido");
    }

    //Verifica se tem imagens
    if (empty($_FILES['image']['name'][0])) {
        throw new Exception("Nenhuma imagem recebida");
    }

    //Cria uma pasta para o usuario se não existir
    $pasta = $diretorio . $usuario;
    
    if (!file_exists($pasta)) {
        if (!mkdir($pasta, 0777, true)) {
            throw new Exception("Erro ao criar a pasta temporaria");
        }
    }
    
    //Verifica se o arquivo enviado é do tipo IMAGEM
    foreach ($_FILES['image']['name'] as $key => $name) {
        $isimg = getimagesize($_FILES['image']['tmp_name'][$key]) ? true : false;
        if ($isimg) {
            $files[] = [
                "name" => basename($name),
                "tmp_name" => $_FILES['image']['tmp_name'][$key]
            ];
        }
    }
    
    //Somente os arquivos que são do tipo imagem, o upload é feito
    foreach ($files as $file) {

        $destination = $pasta . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $return[] = [
                "img" => "files/temp/uploads/" . $usuario . basename($file['name']),
                "stts" => true,
            ];
        } else {
            $return[] = [
                "img" => "files/temp/uploads/" . $usuario . basename($file['name']),
                "stts" => false,
            ];
        }
    }

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
?>
