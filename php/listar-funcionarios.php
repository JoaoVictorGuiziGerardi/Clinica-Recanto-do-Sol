<?php

  require_once "conexaoMysql.php";
  require_once "autenticacao.php";

  session_start();
  $pdo = mysqlConnect();
  exitWhenNotLogged($pdo);

  try{
      $sql = <<<SQL
        SELECT nome, sexo, email, telefone, cep, logradouro, cidade, estado, data_contrato, salario, especialidade, crm FROM pessoa
        INNER JOIN funcionario ON funcionario.id_funcionario = pessoa.id
        INNER JOIN medico on medico.id_medico = pessoa.id;
      SQL;

      // Porque não há risco de uma sql injection:
      $stmt = $pdo->query($sql);
      
      $sql2 = <<<SQL
        SELECT nome, sexo, email, telefone, cep, logradouro, cidade, estado, data_contrato, salario FROM pessoa
        INNER JOIN funcionario ON funcionario.id_funcionario = pessoa.id
        WHERE pessoa.id NOT IN (SELECT id_medico FROM medico);
      SQL;

      // Porque não há risco de uma sql injection:
      $stmt2 = $pdo->query($sql2);
  } catch (Exception $e){
      exit("Ocorreu uma falha: " . $e->getMessage());
  }

?>

<!doctype html>
<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clínica - Restrito</title>

         <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

        <link rel="stylesheet" href="../css/restrita.css">
    </head>

    <body>

        <header>
            <h1> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 1 16 16">
                    <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                </svg>
                Recanto do Sol
            </h1> 
        </header>

        <nav>

            <section>
                <ul id="nav">
                    <li> <a href="restrita.php"> Novo Funcionário </a> </li>
                    <li> <a href="novo-paciente.php"> Novo Paciente </a> </li>
                    <li> <a href="listar-funcionarios.php"> <b>Listar Funcionários</b> </a> </li>
                    <li> <a href="listar-pacientes.php"> Listar Pacientes </a> </li>
                    <li> <a href="listar-enderecos.php"> Listar Endereços </a> </li>
                    <li> <a href="listar-todosAgendamentos.php"> Listar Todos Agendamentos </a> </li>
                    <?php
                        $id = ehMedico($pdo);

                        if ($id != false){
                            echo <<<HTML
                                <li> <a href="listar-meusAgendamentos.php"> Listar Meus Agendamentos </a> </li>
                            HTML;
                        }
                    ?>
                    <li> <a href="logout.php"> SAIR </a> </li>
                </ul>
            </section>

        </nav>

        <main>
            <div class="tabs table-responsive">
                <h1>Funcionários Cadastrados</h1>
                <hr />
                <table class="table table-striped table-hover mt-3">
                    <thead> 
                        <tr>
                            <th>Nome</th>
                            <th>Sexo</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>CEP</th>
                            <th>Logradouro</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Data Início</th>
                            <th>Salário</th>
                            <th>Especialidade</th>
                            <th>CRM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch()){
                            $nome = htmlspecialchars($row["nome"]);
                            $sexo = htmlspecialchars($row["sexo"]);
                            $email = htmlspecialchars($row["email"]);
                            $telefone = htmlspecialchars($row["telefone"]);
                            $cep = htmlspecialchars($row["cep"]);
                            $logradouro = htmlspecialchars($row["logradouro"]);
                            $cidade = htmlspecialchars($row["cidade"]);
                            $estado = htmlspecialchars($row["estado"]);
                            $data_inicio = htmlspecialchars($row["data_contrato"]);
                            $salario = htmlspecialchars($row["salario"]);
                            $esp = htmlspecialchars($row["especialidade"]);
                            $crm = htmlspecialchars($row["crm"]);

                            echo <<<HTML

                                <tr>
                                    <td>$nome</td>
                                    <td>$sexo</td>
                                    <td>$email</td>
                                    <td>$telefone</td>
                                    <td>$cep</td>
                                    <td>$logradouro</td>
                                    <td>$cidade</td>
                                    <td>$estado</td>
                                    <td>$data_inicio</td>
                                    <td>$salario</td>
                                    <td>$esp</td>
                                    <td>$crm</td>
                                </tr>

                            HTML;
                        }
                        ?>
                        <?php
                        while ($row = $stmt2->fetch()){
                            $nome2 = htmlspecialchars($row["nome"]);
                            $sexo2 = htmlspecialchars($row["sexo"]);
                            $email2 = htmlspecialchars($row["email"]);
                            $telefone2 = htmlspecialchars($row["telefone"]);
                            $cep2 = htmlspecialchars($row["cep"]);
                            $logradouro2 = htmlspecialchars($row["logradouro"]);
                            $cidade2 = htmlspecialchars($row["cidade"]);
                            $estado2 = htmlspecialchars($row["estado"]);
                            $data_inicio2 = htmlspecialchars($row["data_contrato"]);
                            $salario2 = htmlspecialchars($row["salario"]);

                            echo <<<HTML

                                <tr>
                                    <td>$nome2</td>
                                    <td>$sexo2</td>
                                    <td>$email2</td>
                                    <td>$telefone2</td>
                                    <td>$cep2</td>
                                    <td>$logradouro2</td>
                                    <td>$cidade2</td>
                                    <td>$estado2</td>
                                    <td>$data_inicio2</td>
                                    <td>$salario2</td>
                                </tr>

                            HTML;
                        }
                        ?>


                    </tbody>
                </table>

            </div>

        </main>

        <footer>

            <h3>Copyright © 2022 - Todos os direitos reservados -<a href="#">Clinica.com</a> </h3>

        </footer>
    </body>    
        

</html>