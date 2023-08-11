<?php

require_once 'Database.php';

class TokenAPI {

    private $token = "TjjAk5&5oVGL9mb#";

    public function __construct() {
        
    }

    public function ValidTokenAPI($tk) {
        
        $conexao = Database::conexao('PRD');
        $sql = "SELECT * FROM T_TOKEN WHERE TK_COD = '{$tk}'";
        $stmt = $conexao->query($sql);
        $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
        $conexao = null;
        
        if (empty($consulta)) {
            return false;
        } else {
            return true;
        }
    }

}
