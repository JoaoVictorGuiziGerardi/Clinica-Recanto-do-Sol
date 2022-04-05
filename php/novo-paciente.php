<?php

require_once "conexaoMysql.php";
require_once "autenticacao.php";

session_start();
$pdo = mysqlConnect();
exitWhenNotLogged($pdo);

?>

<!DOCTYPE html>
<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <title>Clínica - Restrito</title>
        <link rel="stylesheet" href="../css/restrita.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                    <li> <a href="novo-paciente.php"> <b>Novo Paciente</b> </a> </li>
                    <li> <a href="listar-funcionarios.php"> Listar Funcionários </a> </li>
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

            <div class="tabs">

                <section data-tabname="NovoPaciente">
                    <h1>Cadastro de Novo Paciente</h1>
                    <hr />

                    <form action="../php/cadastra-paciente.php" method="POST" class="form-enderecoA">
                        <div class="row gy-4 gx-5 m-4 p-2">

                            <div class="col-sm-8">
                                <label for="inputNome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="inputNome" name="inputNome">
                            </div>
            
                            <div class="col-sm-4">
                                <label for="inputSexo" class="form-label">Sexo</label>
                                <input type="text" class="form-control" id="inputSexo" name="inputSexo">
                            </div>

                            <div class="col-sm-8">
                                <label for="inputEmail" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="inputEmail" name="inputEmail">
                            </div>
            
                            <div class="col-sm-4">
                                <label for="inputTelefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="inputTelefone" name="inputTelefone">
                            </div>

                            <div class="col-sm-3">
                                <label for="inputCEPp" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="inputCEPp" name="inputCEP" oninput="buscaEndereco()">
                            </div>
            
                            <div class="col-sm-9">
                                <label for="inputLogradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" id="inputLogradouro" name="inputLogradouro">
                            </div>
            
                            <div class="col-sm-6">
                                <label for="inputCidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="inputCidade" name="inputCidade">
                            </div>

                            <div class="col-sm-6">
                                <label for="inputEstado" class="form-label">Estado</label>
                                <select id="inputEstado" class="form-select" name="inputEstado">
                                    <option selected>Sel.</option>
                                    <option>SP</option>
                                    <option>MG</option>
                                    <option>RJ</option>
                                    <option>ES</option>
                                </select>
                                
                            </div>

                            <div class="col-sm-4">
                                <label for="inputPeso" class="form-label">Peso (em Kg)</label>
                                <input type="number" class="form-control" id="inputPeso" name="inputPeso">
                            </div>
            
                            <div class="col-sm-4">
                                <label for="inputAltura" class="form-label">Altura (em cm)</label>
                                <input type="number" class="form-control" id="inputAltura" name="inputAltura">
                            </div>

                            <div class="col-sm-4">
                                <label for="inputTipoSanguineo" class="form-label">Tipo Sanguíneo</label>
                                <input type="text" class="form-control" id="inputTipoSanguineo" name="inputTipoSanguineo">
                            </div>

                            <div class="col-sm-12 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg>
                                </button>
                            </div>
            
                        </div>
                    </form>
                </section>

            </div>


        </main>

        <footer>

            <h3>Copyright © 2022 - Todos os direitos reservados -<a href="#">Clinica.com</a> </h3>

        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script>

            function buscaEndereco() {
                const cep = document.querySelector("#inputCEPp").value;
                console.log(cep);
                
                if (cep.length != 9) return;

                let xhr = new XMLHttpRequest();
                xhr.open("GET", "busca-endereco.php?inputCEP=" + cep, true);

                xhr.onload = function () {
        
                // verifica o código de status retornado pelo servidor
                if (xhr.status != 200) {
                    console.error("Falha inesperada: " + xhr.responseText);
                    return;
                }
                
                // converte a string JSON para objeto JavaScript
                try {
                    var endereco = JSON.parse(xhr.responseText);
                }
                catch (e) {
                    console.error("String JSON inválida: " + xhr.responseText);
                    return;
                }

                // utiliza os dados retornados para preencher formulário
                let form = document.querySelector(".form-enderecoA");
                form.inputLogradouro.value = endereco.logradouro;
                form.inputCidade.value = endereco.cidade;
                form.inputEstado.value = endereco.estado;
                }

                xhr.onerror = function () {
                    console.error("Erro de rede - requisição não finalizada");
                };

                xhr.send();
            }

        </script>

    </body>

</html>