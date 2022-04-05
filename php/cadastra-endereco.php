<?php

  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $cep = $_POST["inputCEP"];
  $logradouro = $_POST["inputLogradouro"];
  $cidade = $_POST["inputCidade"];
  $estado = $_POST["inputEstado"];

  $cep = htmlspecialchars($cep);
  $logradouro = htmlspecialchars($logradouro);
  $cidade = htmlspecialchars($cidade);
  $estado = htmlspecialchars($estado);

  try{
        $sql = <<<SQL

          INSERT INTO base_enderecos (cep, logradouro, cidade, estado)
          VALUES (?, ?, ?, ?)

        SQL;

        // Já que foram dados inseridos pelo usuário:
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $cep, $logradouro, $cidade, $estado
        ]);

        header("location: ../html/novoendereco.html");
        exit();
  }
  catch (Exception $e){
      exit("Falha no cadastro: " . $e->getMessage());
  }

  
?>