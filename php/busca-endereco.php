<?php

  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $cep = $_GET['inputCEP'] ?? '';
  
  try {
      $sql = "SELECT cep, logradouro, cidade, estado FROM base_enderecos";

      $stmt = $pdo->query($sql);

  } catch (Exception $e) {
      exit("Ocorreu uma falha: " . $e->getMessage());
  }

  class Endereco
  {
    public $logradouro;
    public $cidade;
    public $estado;

    function __construct($logradouro, $cidade, $estado)
    {
      $this->logradouro = $logradouro;
      $this->cidade = $cidade;
      $this->estado = $estado; 
    }
  }

  while($row = $stmt->fetch()){

    if (strcmp($row["cep"], $cep) == 0){
      $cep_var = htmlspecialchars($row["cep"]);
      $logradouro_var = htmlspecialchars($row["logradouro"]);
      $cidade_var = htmlspecialchars($row["cidade"]);
      $estado_var = htmlspecialchars($row["estado"]);

      break;
    }
  }
    
  $endereco = new Endereco($logradouro_var, $cidade_var, $estado_var);
  
  echo json_encode($endereco);

?>