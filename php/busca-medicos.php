<?php

require "conexaoMysql.php";
$pdo = mysqlConnect();

$especialidade = $_GET['especialidade'] ?? '';

try {
    $sql = "SELECT nome, id_medico FROM pessoa INNER JOIN medico ON medico.id_medico = pessoa.id WHERE medico.especialidade = '".$especialidade."'";

    $stmt = $pdo->query($sql);

} catch (Exception $e) {
    exit("Ocorreu uma falha: " . $e->getMessage());
}

class Medico {
    public $nome;
    public $id;

    function __construct($id, $nome){
        $this->id = $id;
        $this->nome = $nome;
    }
}

$medico = array();
$i = 0;

while($row = $stmt->fetch()){   
    $nome = htmlspecialchars($row['nome']);
    $id = htmlspecialchars($row['id_medico']);
    $medico[$i] = new Medico($id, $nome);
    $i = $i + 1;
}

echo json_encode($medico);

?>