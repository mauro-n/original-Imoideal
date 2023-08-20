<?php

class Database {

    protected static $amb;
    protected static $db;

    private function __construct($amb) {
        self::$amb = $amb;
        
        $db_host = "srv185.hstgr.io";
        $db_driver = "mysql";
        
        switch ($amb) {
            case 'PRD':
                $db_nome = "u440131743_imoideal";
                $db_usuario = "u440131743_imoideal";
                $db_senha = "X?tOmV8T3j9>";
                break;
            case 'SBX':
                $db_nome = "u440131743_imoideal_QAS";
                $db_usuario = "u440131743_imoideal_QAS";
                $db_senha = "?1ejslT[vjzX";
                break;
            default:
                die("Connection Error: Ambiente Não Definido");
                break;
        }

        # Informações sobre o sistema:
        $sistema_titulo = "Imodieal";
        $sistema_email = "suporte@imoideal.com";

        try {
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            # Envia um e-mail para o e-mail oficial do sistema, em caso de erro de conexão.
            #mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
            # Então não carrega nada mais da página.
            die("Connection Error: " . $e->getMessage());
        }
    }

    public static function conexao($amb = 'PRD') {
        if (!self::$db || self::$amb != $amb) {
            new Database($amb);
        }
        return self::$db;
    }

    public static function GetAmbiente() {
        return self::$amb;
    }

}

?>