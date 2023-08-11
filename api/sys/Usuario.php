<?php

require_once 'Database.php';

date_default_timezone_set('America/Fortaleza');

class Usuario {

    private $ambiente;
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

    public function __construct($amb) {
        $this->ambiente = $amb;
    }

    private function getData() {
        $date = date_create();
        return date_format($date, "Y-m-d H:i:s");
    }

    private function GeradorCod() {

        $ano = date("Y");
        $mes = date("m");
        $dia = date("d");
        $hor = date('H');
        $min = date('i');
        $seg = date('s');
        $cod = $ano . $mes . $dia . $hor . $min . $seg;

        return $cod;
    }

    public function CreateUser($e, $p, $n, $t) {

        $email = $e;
        $pass = base64_encode($p);
        $nome = $n;
        $telf = $t;

        $array = [
            "status" => false,
            "msglog" => "",
            "dados" => []
        ];

        try {

            $conexao = Database::conexao($this->ambiente);

            //Validando E-mail
            if (empty($email)) {
                throw new Exception("E-mail está vazio");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("E-mail inválido");
            }

            $sql = "SELECT COUNT(USR_EMAL) FROM T_USER WHERE USR_EMAL = '{$email}'";
            $stmt = $conexao->query($sql);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("E-mail já cadastrado");
            }

            //Validando Nome
            if (empty($nome)) {
                throw new Exception("Nome está vazio");
            }

            //Validando Senha
            if (empty($pass)) {
                throw new Exception("Senha está vazia");
            }

            //Validando Telefone
            $telf = preg_replace("/[^0-9]/", "", $telf);
            if (empty($telf)) {
                throw new Exception("Telefone está vazio");
            }
            if (strlen($telf) != 10 && strlen($telf) != 11) {
                throw new Exception("Telefone inválido");
            }

            $conexao->beginTransaction();

            //Gerar o codigo do User
            $this->USR_ICOD = $this->GeradorCod();

            //Pega a data atual
            $dataatual = $this->getData();

            $this->USR_EMAL = $email;
            $this->USR_PASS = $pass;
            $this->USR_IMGP = "default.png";
            $this->USR_NOME = $nome;
            $this->USR_TELF = $telf;
            $this->USR_PLAN = 0;

            if ($this->ambiente == "PRD") {
                $this->USR_STTS = 0;
                $this->USR_WPVF = 0;
            } else {
                $this->USR_STTS = 1;
                $this->USR_WPVF = 1;
            }

            $this->USR_RSTP = 0;

            $fields = "USR_ICOD, USR_EMAL, USR_PASS, USR_IMGP, USR_NOME, USR_TELF, USR_PLAN, USR_STTS, USR_WPVF, USR_RSTP, USR_DTC, USR_DTL, USR_DTA";
            $values = ":ICOD, :EMAL, :PASS, :IMGP, :NOME, :TELF, :PLAN, :STTS, :WPVF, :RSTP, :DTC, :DTL, :DTA";

            $sql = "INSERT INTO T_USER (" . $fields . ") VALUES (" . $values . ");";
            $stmt = $conexao->prepare($sql);
            $stmt->execute(array(
                ':ICOD' => $this->USR_ICOD,
                ':EMAL' => $this->USR_EMAL,
                ':PASS' => $this->USR_PASS,
                ':IMGP' => $this->USR_IMGP,
                ':NOME' => $this->USR_NOME,
                ':TELF' => $this->USR_TELF,
                ':PLAN' => $this->USR_PLAN,
                ':STTS' => $this->USR_STTS,
                ':WPVF' => $this->USR_WPVF,
                ':RSTP' => $this->USR_RSTP,
                ':DTC' => $dataatual,
                ':DTL' => $dataatual,
                ':DTA' => $dataatual,
            ));

            $conexao->commit();
            $conexao = null;

            $array["status"] = true;
            $array["msglog"] = "OK";
            $array["dados"] = [
                "userid" => intval($this->USR_ICOD),
                "urlimg" => "https://imoideal.com/source/img/perfil/" . $this->USR_IMGP,
                "email" => $this->USR_EMAL,
                "nome" => $this->USR_NOME,
                "telefone" => $this->USR_TELF,
                "plan" => $this->USR_PLAN,
                "status" => $this->USR_STTS,
                "checkwpp" => $this->USR_WPVF,
                "resetpass" => $this->USR_RSTP,
                "datacriac" => $dataatual,
                "dataedit" => $dataatual,
            ];
        } catch (Exception $exc) {
            $conexao = null;
            $array["status"] = false;
            $array["msglog"] = $exc->getMessage();
            $array["dados"] = [];
        }

        return $array;
    }

    public function ValidLogin($e, $p) {

        $email = $e;
        $pass = base64_encode($p);

        $array = [
            "status" => false,
            "msglog" => "",
            "dados" => []
        ];

        try {

            $conexao = Database::conexao($this->ambiente);

            //Validando E-mail
            if (empty($email)) {
                throw new Exception("E-mail está vazio");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("E-mail inválido");
            }

            //Validando Senha
            if (empty($pass)) {
                throw new Exception("Senha está vazia");
            }

            $sql = "SELECT * FROM T_USER WHERE USR_EMAL = '{$email}'";
            $stmt = $conexao->query($sql);
            $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($consulta['USR_EMAL'])) {
                throw new Exception("Usuário não cadastrado");
            } else {
                if ($pass != $consulta['USR_PASS']) {
                    throw new Exception("Senha inválida");
                }
            }

            $conexao = null;

            $array["status"] = true;
            $array["msglog"] = "OK";
            $array["dados"] = [
                "userid" => intval($consulta['USR_ICOD']),
                "urlimg" => "https://imoideal.com/source/img/perfil/" . $consulta['USR_IMGP'],
                "email" => $consulta['USR_EMAL'],
                "nome" => $consulta['USR_NOME'],
                "telefone" => $consulta['USR_TELF'],
                "plan" => intval($consulta['USR_PLAN']),
                "status" => intval($consulta['USR_STTS']),
                "checkwpp" => intval($consulta['USR_WPVF']),
                "resetpass" => intval($consulta['USR_RSTP']),
                "datacriac" => $consulta['USR_DTC'],
                "dataedit" => $consulta['USR_DTA'],
            ];
        } catch (Exception $exc) {
            $conexao = null;
            $array["status"] = false;
            $array["msglog"] = $exc->getMessage();
            $array["dados"] = [];
        }

        return $array;
    }

    public function GetUser($id) {
        
        $array = [
            "status" => false,
            "msglog" => "",
            "dados" => []
        ];

        try {

            $conexao = Database::conexao($this->ambiente);

            $sql = "SELECT * FROM T_USER WHERE USR_ICOD = '{$id}'";
            $stmt = $conexao->query($sql);
            $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($consulta['USR_ICOD'])) {
                throw new Exception("Usuário não cadastrado");
            }
            
            $conexao = null;

            $array["status"] = true;
            $array["msglog"] = "OK";
            $array["dados"] = [
                "userid" => intval($consulta['USR_ICOD']),
                "urlimg" => "https://imoideal.com/source/img/perfil/" . $consulta['USR_IMGP'],
                "email" => $consulta['USR_EMAL'],
                "nome" => $consulta['USR_NOME'],
                "telefone" => $consulta['USR_TELF'],
                "plan" => intval($consulta['USR_PLAN']),
                "status" => intval($consulta['USR_STTS']),
                "checkwpp" => intval($consulta['USR_WPVF']),
                "resetpass" => intval($consulta['USR_RSTP']),
                "datacriac" => $consulta['USR_DTC'],
                "dataedit" => $consulta['USR_DTA'],
            ];
        } catch (Exception $exc) {
            $conexao = null;
            $array["status"] = false;
            $array["msglog"] = $exc->getMessage();
            $array["dados"] = [];
        }

        return $array;
    }

}
