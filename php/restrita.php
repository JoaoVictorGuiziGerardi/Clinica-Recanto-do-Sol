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
                    <li> <a href="restrita.php"> <b>Novo Funcionário</b> </a> </li>
                    <li> <a href="novo-paciente.php"> Novo Paciente </a> </li>
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

                <section data-tabname="NovoFuncionario">
                    <h1>Cadastro de Novo Funcionário</h1>
                    <hr />

                    <form action="../php/cadastra-funcionario.php" method="POST" class="form-endereco">
                        <div class="row gy-4 gx-5 m-4 p-2 justify-content-md-center">

                            <div class="col-sm-8">
                                <label for="inputNomeF" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="inputNomeF" name="inputNomeF">
                            </div>
            
                            <div class="col-sm-4">
                                <label for="inputSexoF" class="form-label">Sexo</label>
                                <input type="text" class="form-control" id="inputSexoF" name="inputSexoF">
                            </div>

                            <div class="col-sm-8">
                                <label for="inputEmailF" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="inputEmailF" name="inputEmailF">
                            </div>
            
                            <div class="col-sm-4">
                                <label for="inputTelefoneF" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="inputTelefoneF" name="inputTelefoneF">
                            </div>

                            <div class="col-sm-3">
                                <label for="inputCEP" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="inputCEP" name="inputCEP" oninput="buscaEnderecoF()">
                            </div>
            
                            <div class="col-sm-9">
                                <label for="inputLogradouroF" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" id="inputLogradouroF" name="inputLogradouroF">
                            </div>
            
                            <div class="col-sm-6">
                                <label for="inputCidadeF" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="inputCidadeF" name="inputCidadeF">
                            </div>

                            <div class="col-sm-6">
                                <label for="inputEstadoF" class="form-label">Estado</label>
                                <select id="inputEstadoF" class="form-select" name="inputEstadoF">
                                    <option selected>Sel.</option>
                                    <option>SP</option>
                                    <option>MG</option>
                                    <option>RJ</option>
                                    <option>ES</option>
                                </select>
                                
                            </div>

                            <div class="col-sm-4">
                                <label for="inputDataInicioContratoF" class="form-label">Data Início Contrato</label>
                                <input type="date" class="form-control" id="inputDataInicioContratoF" name="inputDataInicioContratoF">
                            </div>

                            <div class="col-sm-4">
                                <label for="inputSalarioF" class="form-label">Salário</label>
                                <input type="number" class="form-control" id="inputSalarioF" name="inputSalarioF" pattern="^\d*(\.\d{0,2})?$">
                            </div>

                            <div class="col-sm-4">
                                <label for="inputSenhaF" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="inputSenhaF" name="inputSenhaF">
                            </div>

                            <div class="col-sm-5">
                                <h4>O funcionário é médico?</h4>
                            </div>

                            <div class="col-sm-5 form-check">
                                <select name="ehMedico" id="select-medico" class="form-select" onchange="medicoform()">
                                    <option value="selecione" selected>Selecione</option>
                                    <option value="sim">Sim</option>
                                    <option value="nao">Não</option>
                                </select>
                            </div>

                            <div id="div-medico" class="nao-medico-form">
                                <div class="row">
                                    <div class="col-sm-4" >
                                        <label for="inputCRM" class="form-label">CRM</label>
                                        <input type="text" class="form-control" id="inputCRM" name="inputCRM">
                                    </div>

                                    <div class="col-sm-8">
                                        <label for="inputEspecialidade" class="form-label">Especialidade</label>
                                        <input type="text" class="form-control" id="inputEspecialidade" name="inputEspecialidade">
                                    </div>
                                </div>
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
            
            function medicoform(radio) {

                const selecao = document.getElementById("select-medico");
                const div = document.getElementById("div-medico");

                console.log(selecao.value);

                if (selecao.value === "sim"){
                    div.className = "";
                }
                else if(selecao.value === "nao" || selecao.value === "selecione"){
                    div.className = "nao-medico-form";
                }
            }

            function buscaEnderecoF() {
                const cep = document.querySelector("#inputCEP").value;
                
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
                let form = document.querySelector(".form-endereco");
                form.inputLogradouroF.value = endereco.logradouro;
                form.inputCidadeF.value = endereco.cidade;
                form.inputEstadoF.value = endereco.estado;
                }

                xhr.onerror = function () {
                    console.error("Erro de rede - requisição não finalizada");
                };

                xhr.send();
            }

        </script>

    </body>

</html>