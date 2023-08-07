<?php

require_once 'Database.php';

date_default_timezone_set('America/Fortaleza');

class Usuario {

    private $USR_ICOD;

    #Dados Cliente#
    private $USR_EMAL;
    private $USR_KBOT;
    private $USR_PASS;
    private $USR_IMGP;
    private $USR_NOME;
    private $USR_TELF;
    private $USR_PLAN;

    #Campos do sistema#
    private $USR_STTS;
    private $USR_WPVF;
    private $USR_CDWP;
    private $USR_RSTP;
    private $USR_CDPS;

    #Datas
    private $USR_DTC;
    private $USR_DTL;
    private $USR_DTA;

    public function __construct() {
        
    }

    private function GeradorCod() {

        $conexao = Database::conexao('PRD');
        $conexao = null;

        $ano = date("Y");
        $mes = date("m");
        $dia = date("d");
        $hor = date('H');
        $min = date('i');
        $seg = date('s');
        $cod = $ano . $mes . $dia . $hor . $min . $seg;

        return $cod;
    }

    public function CreateUser($email, $pass, $nome, $wpp) {

        $array = [
            "status" => 0,
            "msglog" => "",
            "dados" => []
        ];

        try {

            $array["status"] = 1;
            $array["msglog"] = "OK";
            $array["dados"] = [
                "email" => "teste@user.com.br",
                "nome" => "Nome Teste",
                "telf" => "+55 85 988206336"
            ];
            
        } catch (Exception $exc) {
            $array["status"] = 0;
            $array["msglog"] = $exc->getMessage();
            $array["dados"] = [];
        }

        return $array;
    }

}
