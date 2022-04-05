<?php

  require_once "conexaoMysql.php";
  require_once "autenticacao.php";

  session_start();
  $pdo = mysqlConnect();
  exitWhenNotLogged($pdo);
  $id = ehMedico($pdo);
  
  if ($id != false){
     try{
        $sql = <<<SQL
            SELECT nome_paciente, agenda.email, sexo_paciente, data_consulta, horario_consulta FROM agenda
            INNER JOIN pessoa ON pessoa.id = agenda.id_medico
            INNER JOIN medico ON medico.id_medico = agenda.id_medico
            WHERE agenda.id_medico = $id  
        SQL;

        // Porque não há risco de uma sql injection:
        $stmt = $pdo->query($sql);
     }
     catch (Exception $e){
        exit("Ocorreu uma falha: " . $e->getMessage());
     } 
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
                    <li> <a href="listar-funcionarios.php"> Listar Funcionários </a> </li>
                    <li> <a href="listar-pacientes.php"> Listar Pacientes </a> </li>
                    <li> <a href="listar-enderecos.php"> Listar Endereços </a> </li>
                    <li> <a href="listar-todosAgendamentos.php"> Listar Todos Agendamentos </a> </li>
                    <li> <a href="listar-meusAgendamentos.php"> <b>Listar Meus Agendamentos</b> </a> </li>
                    <li> <a href="logout.php"> SAIR </a> </li>
                </ul>
            </section>

        </nav>

        <main>
        <div class="tabs table-responsive">
                <h1>Meus Agendamentos Cadastrados</h1>
                <hr />
                <table class="table table-striped table-hover mt-3">
                    <thead> 
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Sexo</th>
                            <th>Data</th>
                            <th>Horário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch()){
                            $nome_paciente = htmlspecialchars($row["nome_paciente"]);
                            $email = htmlspecialchars($row["email"]);
                            $sexo = htmlspecialchars($row["sexo_paciente"]);
                            $data_consulta = htmlspecialchars($row["data_consulta"]);
                            $horario_consulta = htmlspecialchars($row["horario_consulta"]);

                            echo <<<HTML

                                <tr>
                                    <td>$nome_paciente</td>
                                    <td>$email</td>
                                    <td>$sexo</td>
                                    <td>$data_consulta</td>
                                    <td>$horario_consulta</td>
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