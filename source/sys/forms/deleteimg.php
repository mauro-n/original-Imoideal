<?php

$diretorio = '../../../files/temp/uploads/';

$retorno = [
    'status' => false,
    'message' => ""
];

try {

    //Valida a sessão
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['USER']['userid'])) {
        throw new Exception("Usuario não está logado");
    }

    //Recupera o ID do usuario
    $id = $_SESSION['USER']['userid'];
    $userpath = $_SESSION['USER']['userid'] . "/";

    //Verifica se a conexão é via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de envio inválido");
    }

    //Verifica se tem imagens
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['img'])) {
        throw new Exception("Nenhum codigo de imagem foi enviado");
    }

    //Verifica se o codigo de usuario é mesmo
    $url = explode("/", $data['img']);

    $noauth = true;
    foreach ($url as $u) {
        if ($u == $id) {
            $noauth = false;
        }
        $imgname = $u;
    }

    if ($noauth) {
        throw new Exception("Sem permissão para excluir essa imagem");
    }

    //Cria uma pasta para o usuario se não existir
    $pasta = $diretorio . $userpath . $imgname;

    if (!file_exists($pasta)) {
        throw new Exception("Imagem não existe no servidor");
    }

    unlink($pasta);
    
    http_response_code(200);
    $retorno['status'] = true;
    $retorno['message'] = "Sucesso";
} catch (Exception $exc) {
    http_response_code(400);
    $retorno['status'] = false;
    $retorno['message'] = $exc->getMessage();
}

echo json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>