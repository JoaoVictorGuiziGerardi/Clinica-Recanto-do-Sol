<?php

function checkPassword($pdo, $email, $senha){
    $sql = <<<SQL
        SELECT hash_senha FROM funcionario
        INNER JOIN pessoa ON pessoa.id = funcionario.id_funcionario
        WHERE pessoa.email = ?
    SQL;

    try{
        // Já que tem risco de sql injection:
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        $hash_senha = $row['hash_senha'];

        if(!$hash_senha) return false; // nenhum resultado (email não encontrado)

        if(!password_verify($senha, $hash_senha)) return false; // senha errada

        return $hash_senha;
    }
    catch (Exception $e){
        exit("Ocorreu um erro: " . $e->getMessage());
    }
    
}

function checkLogged($pdo){
    // Verifica se as variáveis de sessão criadas
    // no momento do login estão definidas
    if (!isset($_SESSION['emailUsuario'], $_SESSION['loginString']))
        return false;

    $email = $_SESSION['emailUsuario'];

    // Resgata a senha hash armazenada para conferência
    $sql = <<<SQL
        SELECT hash_senha FROM funcionario
        INNER JOIN pessoa ON pessoa.id = funcionario.id_funcionario
        WHERE pessoa.email = ?
    SQL;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        $hash_senha = $row['hash_senha'];
    
        if (!$hash_senha) return false; // nenhum resultado (email não encontrado)

        // Gera uma nova string de login com base nos dados
        // atuais do navegador do usuário e compara com a
        // string de login gerada anteriormente no momento do login
        $loginStringCheck = hash('sha512', $hash_senha . $_SERVER['HTTP_USER_AGENT']);
        if (!hash_equals($loginStringCheck, $_SESSION['loginString']))
            return false;

        return true;
    } 
    catch (Exception $e) {
        exit('Falha inesperada: ' . $e->getMessage());
    }
}

function exitWhenNotLogged($pdo){
    if (!checkLogged($pdo)) {
        header("Location: ../index.html");
        exit();
    }
}

function ehMedico($pdo){
    if (!isset($_SESSION['emailUsuario'], $_SESSION['loginString']))
        return false;

    $email = $_SESSION['emailUsuario'];

    $sql = <<<SQL
        SELECT id_medico FROM pessoa
        INNER JOIN medico ON medico.id_medico = pessoa.id
        WHERE ? = pessoa.email AND pessoa.id = medico.id_medico;
    SQL;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        $id = $row['id_medico'];

        if (!$id) return false;

        return $id;

    } catch(Exception $e) {
        exit('Falha inesperada: ' . $e->getMessage());
    }
}

?>