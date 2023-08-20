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

$types_f = [0, 1, 2, 3];

$input = [
    "catg_a" => "",
    "type_a" => "",
    "type_f" => "",
    "text" => "",
];

$return = [];

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

    //Validação Categoria
    if (isset($data['catg_a'])) {
        $conexao = Database::conexao('PRD');
        $sql = "SELECT COUNT(CAT_ICOD) FROM T_CATG_ANUNC WHERE CAT_ICOD = {$data['catg_a']};";
        $stmt = $conexao->query($sql);
        if ($stmt->fetchColumn() < 1) {
            throw new Exception("Parametro catg_a é inválido");
        }
        $conexao = null;
        $input['catg_a'] = $data['catg_a'];
    } else {
        throw new Exception("Parametro catg_a não recebido");
    }

    //Validação Tipo
    if (isset($data['type_a'])) {
        $conexao = Database::conexao('PRD');
        $sql = "SELECT COUNT(TYP_ICOD) FROM T_TYPE_ANUNC WHERE TYP_ICOD = {$data['type_a']};";
        $stmt = $conexao->query($sql);
        if ($stmt->fetchColumn() < 1) {
            throw new Exception("Parametro type_a é inválido");
        }
        $conexao = null;
        $input['type_a'] = $data['type_a'];
    } else {
        throw new Exception("Parametro type_a não recebido");
    }

    //Validação Type F
    if (isset($data['type_f'])) {
        if (!in_array($data['type_f'], $types_f)) {
            throw new Exception("Parametro type_f é inválido");
        }
        $input['type_f'] = $data['type_f'];
    } else {
        throw new Exception("Parametro type_f não recebido");
    }

    //Validação Text
    if (isset($data['text'])) {
        $input['text'] = $data['text'];
    } else {
        throw new Exception("Parametro text não recebido");
    }

    $conexao = Database::conexao($amb);

    $ordm = "ORDER BY CASE WHEN ANC_DEST = 1 THEN 0 ELSE 1 END, ANC_PONT DESC, ANC_DATC DESC;";
    $sql = "";

    switch ($input['type_f']) {
        //Rua
        case 0:
            $sql = "SELECT * FROM T_ANUNCIO WHERE ANC_CATG = {$input['catg_a']} AND ANC_TYPE = {$input['type_a']} AND ANC_STRT LIKE '%{$input['text']}%' " . $ordm;
            break;

        //Bairro
        case 1:
            $sql = "SELECT * FROM T_ANUNCIO WHERE ANC_CATG = {$input['catg_a']} AND ANC_TYPE = {$input['type_a']} AND ANC_BAIR LIKE '%{$input['text']}%' " . $ordm;
            break;

        //Cidade
        case 2:
            $sql = "SELECT * FROM T_ANUNCIO WHERE ANC_CATG = {$input['catg_a']} AND ANC_TYPE = {$input['type_a']} AND ANC_CITY LIKE '%{$input['text']}%' " . $ordm;
            break;

        //Estado
        case 3:
            $sql = "SELECT * FROM T_ANUNCIO WHERE ANC_CATG = {$input['catg_a']} AND ANC_TYPE = {$input['type_a']} AND ANC_UFST LIKE '%{$input['text']}%' " . $ordm;
            break;

        default:
            throw new Exception("Parametro type_f é inválido");
            break;
    }

    $consulta = $conexao->query($sql);
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
