<?php

  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $nome = $_POST['inputNome'] ?? '';
  $sexo = $_POST["inputSexo"];
  $email = $_POST["inputEmail"];
  $tel = $_POST["inputTelefone"];
  $cep = $_POST["inputCEP"];
  $logradouro = $_POST["inputLogradouro"];
  $cidade = $_POST["inputCidade"];
  $estado = $_POST["inputEstado"];
  $peso = $_POST["inputPeso"];
  $altura = $_POST["inputAltura"];
  $tipoSanguineo = $_POST["inputTipoSanguineo"];

  //Pessoa
  $nome = htmlspecialchars($nome);
  $sexo = htmlspecialchars($sexo);
  $email = htmlspecialchars($email);
  $tel = htmlspecialchars($tel);
  $cep = htmlspecialchars($cep);
  $logradouro = htmlspecialchars($logradouro);
  $cidade = htmlspecialchars($cidade);
  $estado = htmlspecialchars($estado);

  //Paciente
  $peso = htmlspecialchars($peso);
  $altura = htmlspecialchars($altura);
  $tipoSanguineo = htmlspecialchars($tipoSanguineo);

  try{
        $sql1 = <<<SQL

          INSERT INTO pessoa (nome, sexo, email, telefone, cep, logradouro, cidade, estado)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)

        SQL;

        $sql2 = <<<SQL
          INSERT INTO paciente (id_paciente, peso, altura, tipo_sanguineo)
          VALUES (?, ?, ?, ?)
        SQL;

        $pdo->beginTransaction();

        $stmt1 = $pdo->prepare($sql1);
        if (!$stmt1->execute([
            $nome, $sexo, $email, $tel,
            $cep, $logradouro, $cidade, $estado
        ])) throw new Exception("Falha na primeira inserção");

        $idPessoa = $pdo->lastInsertId();
        $stmt2 = $pdo->prepare($sql2);
        if (!$stmt2->execute([
            $idPessoa, $peso, $altura, $tipoSanguineo
        ])) throw new Exception("Falha na segunda inserção");

        $pdo->commit();

        header("location: listar-pacientes.php");
        exit();
  }
  catch (Exception $e){
    $pdo->rollBack();
    if ($e->errorInfo[1] === 1062)
      exit("Dados duplicados: " . $e->getMessage());
    else
      exit("Falha ao cadastrar os dados: " . $e->getMessage());
  }

  
?> 