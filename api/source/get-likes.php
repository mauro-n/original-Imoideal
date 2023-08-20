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
    
    //Validação Codigo Usuario
    if (isset($_GET['cod'])) {
        if (empty($_GET['cod']) || $_GET['cod'] == "") {
            throw new Exception("Código de usuário não definido");
        }
    } else {
        throw new Exception("Código de usuário não definido");
    }
    
    $cod = intval($_GET['cod']);
    
    $return = [];

    $conexao = Database::conexao($amb);

    $consulta = $conexao->query("SELECT * FROM T_ANUNCIO AS A INNER JOIN T_FAVORITE AS B ON A.ANC_ICOD = B.FAV_ANUC WHERE B.FAV_USER = '{$cod}';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

        $line = [
            "codigo" => 0,
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

        $line["codigo"] = $linha['ANC_ICOD'];

        $line["title"] = $linha['ANC_TITL'];
        $line["descricao"] = $linha['ANC_DESC'];
        $line["price"] = $linha['ANC_VALR'];
        $line["quartos"] = intval($linha['ANC_QRTS']);
        $line["banheiros"] = intval($linha['ANC_BANH']);
        $line["metros"] = intval($linha['ANC_MTRS']);
        $line["vagas"] = intval($linha['ANC_ESTC']);
        $line["areaext"] = boolval($linha['ANC_EXTA']);
        $line["piscina"] = boolval($linha['ANC_PSCN']);
        $line["arealzr"] = boolval($linha['ANC_ARLZ']);
        $line["data"] = $linha['ANC_DATC'];
        $line["pontos"] = $linha['ANC_PONT'];
        $line["address"] = $linha['ANC_ADRS'];
        $line["lat"] = $linha['ANC_LATG'];
        $line["log"] = $linha['ANC_LOGG'];

        $imagens = [];
        $consulta2 = $conexao->query("SELECT * FROM T_ANUN_IMG WHERE AMG_ICOD = '{$linha['ANC_ICOD']}';");
        while ($linha2 = $consulta2->fetch(PDO::FETCH_ASSOC)) {
            $imagens[] = "https://imoideal.com/source/img/anuncio/" . $linha2['AMG_IMG'];
        }
        $line["imagens"] = $imagens;

        $return[] = $line;
    }
    $conexao = null;

    http_response_code(200);
    $json = json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $exc) {
    http_response_code(400);
    $json = json_encode(array('error_message' => $exc->getMessage()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

echo $json;
exit();
