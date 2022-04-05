<?php

function mysqlConnect() {

    $db_host = "fdb33.awardspace.net";
    $db_name = "4005155_trabalho6ex1";
    $db_username = "4005155_trabalho6ex1";
    $db_password = "!pi123GSI#";

    // dsn -> database source name
    $dsn = "mysql:host=$db_host; dbname=$db_name; charset=utf8mb4";

    $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // Desativar operações do prepare statements de forma emulada
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Erros vão ser tratados por meio de exceções
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // MOdifica o método fetch pra trazer array associativo de cada linha relacionado ao nome da coluna
    ];

    try{
        $pdo = new PDO($dsn, $db_username, $db_password, $options);
        return $pdo;
    }
    catch (Exception $e){
        exit("Falha na conexão com o MySQL: " . $e->getMessage());
    }
}

?>