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
    $amb = $_GET['amb'];

    //Validação API Key
    if (isset($_SERVER['HTTP_API_KEY'])) {
        if (!$tokenAPI->ValidTokenAPI($_SERVER['HTTP_API_KEY'])) {
            throw new Exception("API-KEY é inválida");
        }
    } else {
        throw new Exception("API-KEY não definida");
    }

    //Validação Codigo Anuncio
    if (isset($_GET['cod'])) {
        if (empty($_GET['cod']) || $_GET['cod'] == "") {
            throw new Exception("Código do anúncio não definido");
        }
    } else {
        throw new Exception("Código do anúncio não definido");
    }

    $cod = intval($_GET['cod']);

    $return = [
        "codigo" => 0,
        "user" => [
            "img" => "",
            "email" => "",
            "nome" => "",
            "tel" => 0
        ],
        "imagens" => [],
        "title" => "",
        "descricao" => "",
        "price" => "",
        "quartos" => 0,
        "banheiros" => 0,
        "metros" => 0,
        "vagas" => 0,
        "areaext" => false,
        "piscina" => false,
        "arealzr" => false,
        "data" => "",
        "pontos" => "",
        "address" => "",
        "lat" => "",
        "log" => ""
    ];

    $conexao = Database::conexao($amb);

    $sql = "SELECT * FROM T_ANUNCIO WHERE ANC_ICOD = '{$cod}';";
    $stmt = $conexao->query($sql);
    $anuncio = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($anuncio)) {
        throw new Exception("Código do anúncio não existe no sistema");
    }

    $return["codigo"] = $anuncio['ANC_ICOD'];

    $return["title"] = $anuncio['ANC_TITL'];
    $return["descricao"] = $anuncio['ANC_DESC'];
    $return["price"] = $anuncio['ANC_VALR'];
    $return["quartos"] = intval($anuncio['ANC_QRTS']);
    $return["banheiros"] = intval($anuncio['ANC_BANH']);
    $return["metros"] = intval($anuncio['ANC_MTRS']);
    $return["vagas"] = intval($anuncio['ANC_ESTC']);
    $return["areaext"] = boolval($anuncio['ANC_EXTA']);
    $return["piscina"] = boolval($anuncio['ANC_PSCN']);
    $return["arealzr"] = boolval($anuncio['ANC_ARLZ']);
    $return["data"] = $anuncio['ANC_DATC'];
    $return["pontos"] = $anuncio['ANC_PONT'];
    $return["address"] = $anuncio['ANC_ADRS'];
    $return["lat"] = $anuncio['ANC_LATG'];
    $return["log"] = $anuncio['ANC_LOGG'];

    $imagens = [];
    $consulta = $conexao->query("SELECT * FROM T_ANUN_IMG WHERE AMG_ICOD = '{$cod}';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $imagens[] = "https://imoideal.com/source/img/anuncio/" . $linha['AMG_IMG'];
    }
    $return["imagens"] = $imagens;

    $coduser = $anuncio['ANC_USER'];
    $sql = "SELECT * FROM T_USER WHERE USR_ICOD = '{$coduser}';";
    $stmt = $conexao->query($sql);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($usuario)) {
        throw new Exception("Código do anúncio contém erros");
    }

    $return["user"]["img"] = "https://imoideal.com/source/img/perfil/" . $usuario['USR_IMGP'];
    $return["user"]["email"] = $usuario['USR_EMAL'];
    $return["user"]["nome"] = $usuario['USR_NOME'];
    $return["user"]["tel"] = $usuario['USR_TELF'];

    $conexao = null;

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
