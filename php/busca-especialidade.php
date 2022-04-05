<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();

try {
    $sql = "SELECT especialidade FROM medico";

    $stmt = $pdo->query($sql);

} catch (Exception $e) {
    exit("Ocorreu uma falha: " . $e->getMessage());
}

class Especialidade {
    public $especialidade;
    public $value;

    function __construct($especialidade, $value){
        $this->especialidade = $especialidade;
        $this->value = $value;
    }
}

$especialidade = array();
$i = 0;

while($row = $stmt->fetch()){
    $esp = htmlspecialchars($row['especialidade']);
    $especialidade[$i] = new Especialidade($esp, $i);
    $i = $i + 1;
}

echo json_encode($especialidade);

?>