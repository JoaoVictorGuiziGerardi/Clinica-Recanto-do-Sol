<?php

  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $nome = $_POST['inputNomeF'] ?? '';
  $sexo = $_POST["inputSexoF"];
  $email = $_POST["inputEmailF"];
  $tel = $_POST["inputTelefoneF"];
  $cep = $_POST["inputCEP"];
  $logradouro = $_POST["inputLogradouroF"];
  $cidade = $_POST["inputCidadeF"];
  $estado = $_POST["inputEstadoF"];
  $data_inicio = $_POST["inputDataInicioContratoF"];
  $salario = $_POST["inputSalarioF"];
  $senha = $_POST["inputSenhaF"];
  $ehMedico = $_POST["ehMedico"];
  $crm = $_POST["inputCRM"];
  $especialidade = $_POST["inputEspecialidade"];

  //Pessoa
  $nome = htmlspecialchars($nome);
  $sexo = htmlspecialchars($sexo);
  $email = htmlspecialchars($email);
  $tel = htmlspecialchars($tel);
  $cep = htmlspecialchars($cep);
  $logradouro = htmlspecialchars($logradouro);
  $cidade = htmlspecialchars($cidade);
  $estado = htmlspecialchars($estado);

  //Funcionário
  $data_inicio = htmlspecialchars($data_inicio);
  $salario = htmlspecialchars($salario);
  $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

  //Médico
  $ehMedico = htmlspecialchars($ehMedico);
  $crm = htmlspecialchars($crm);
  $especialidade = htmlspecialchars($especialidade);

  try{
        $sql1 = <<<SQL

          INSERT INTO pessoa (nome, sexo, email, telefone, cep, logradouro, cidade, estado)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)

        SQL;

        $sql2 = <<<SQL
          INSERT INTO funcionario (id_funcionario, data_contrato, salario, hash_senha)
          VALUES (?, ?, ?, ?)
        SQL;
        
        $sql3;

        if ($ehMedico == "sim"){
          $sql3 = <<<SQL
            INSERT INTO medico (id_medico, especialidade, crm)
            VALUES (?, ?, ?)
          SQL;
        }

        

        $pdo->beginTransaction();

        $stmt1 = $pdo->prepare($sql1);
        if (!$stmt1->execute([
            $nome, $sexo, $email, $tel,
            $cep, $logradouro, $cidade, $estado
        ])) throw new Exception("Falha na primeira inserção");

        $idPessoa = $pdo->lastInsertId();
        $stmt2 = $pdo->prepare($sql2);
        if (!$stmt2->execute([
            $idPessoa, $data_inicio, $salario, $senhaHash
        ])) throw new Exception("Falha na segunda inserção");

        if ($ehMedico == "sim"){
          $stmt3 = $pdo->prepare($sql3);
          if (!$stmt3->execute([
            $idPessoa, $especialidade, $crm
          ])) throw new Exception("Falha na terceira inserção");
        }
        

        $pdo->commit();

        header("location: listar-funcionarios.php");
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