<?php

  require "conexaoMysql.php";
  $pdo = mysqlConnect();

  $nome = $_POST["inputNome"];
  $email = $_POST["inputEmail-Agendamento"];
  $sexo = $_POST["inputSexo"];
  $especialidade = $_POST["especialidade"];
  $medico = $_POST["medico"];
  $data = $_POST["inputData"];
  $horario = $_POST["horario"];

  $nome = htmlspecialchars($nome);
  $email = htmlspecialchars($email);
  $sexo = htmlspecialchars($sexo);
  $especialidade = htmlspecialchars($especialidade);
  $medico = htmlspecialchars($medico);
  $data = htmlspecialchars($data);
  $horario = htmlspecialchars($horario);

  

  try{
        $sql = "INSERT INTO agenda (data_consulta, horario_consulta, nome_paciente, sexo_paciente, email, id_medico)
                VALUES (?, ?, ?, ?, ?, ?)";

        // Já que foram dados inseridos pelo usuário:
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data, $horario, $nome, $sexo, $email, $medico
        ]);

        header("location: ../html/agendamento.html");
        exit();
  }
  catch (Exception $e){
      exit("Falha no cadastro: " . $e->getMessage());
  }

  
?>