<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();

$data_consulta = $_GET["data_consulta"] ?? '';
$id_medico = $_GET["id_medico"] ?? '';

try {
    $sql = "SELECT horario_consulta FROM agenda WHERE agenda.id_medico = '".$id_medico."' AND agenda.data_consulta = '".$data_consulta."'";

    $stmt = $pdo->query($sql);

} catch (Exception $e) {
    exit("Ocorreu uma falha: " . $e->getMessage());
}

class Horarios {
    public $horario;

    function __construct($horario){
        $this->horario = $horario;
    }
}

$horario = array();
$i = 0;

while($row = $stmt->fetch()){
    $hora = htmlspecialchars($row['horario_consulta']);
    $horario[$i] = new Horarios($hora);
    $i = $i + 1;
}

echo json_encode($horario);

?>