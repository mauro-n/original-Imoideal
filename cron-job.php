<?php

$db_host = "srv185.hstgr.io";
$db_driver = "mysql";

// Conexão com o banco de dados produtivo
$db_nome = "u440131743_imoideal";
$db_usuario = "u440131743_imoideal";
$db_senha = "X?tOmV8T3j9>";

try {
    $conn_produtivo = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
    $conn_produtivo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn_produtivo->exec('SET NAMES utf8');
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados produtivo: " . $e->getMessage();
    exit();
}

// Conexão com o banco de dados sandbox
$db_nome = "u440131743_imoideal_QAS";
$db_usuario = "u440131743_imoideal_QAS";
$db_senha = "?1ejslT[vjzX";

try {
    $conn_sandbox = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
    $conn_sandbox->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn_sandbox->exec('SET NAMES utf8');
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados sandbox: " . $e->getMessage();
    exit();
}

//Seleciona Tabelas
$consulta = $conn_produtivo->query("SHOW TABLES");
$tabelas_prd = $consulta->fetchAll(PDO::FETCH_COLUMN);
$consulta = $conn_sandbox->query("SHOW TABLES");
$tabelas_sbx = $consulta->fetchAll(PDO::FETCH_COLUMN);

//Seleciona campos de tabela
$campos_prd = [];
$campos_sbx = [];

foreach ($tabelas_prd as $tabela) {
    $consulta = $conn_produtivo->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$tabela}';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $campos_prd[] = $linha;
    }
}

foreach ($tabelas_sbx as $tabela) {
    $consulta = $conn_sandbox->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$tabela}';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $campos_sbx[] = $linha;
    }
}


//Verificar Tabelas

echo "<pre>";
print_r($campos_prd);
echo "</pre>";

// Fechar as conexões
$conn_sandbox = null;
$conn_produtivo = null;
?>
