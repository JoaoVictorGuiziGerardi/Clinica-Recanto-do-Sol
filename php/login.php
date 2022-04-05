<?php

require_once "conexaoMysql.php";
require_once "autenticacao.php";
session_start();

class RequestResponse
{
  public $success;
  public $detail;

  function __construct($success, $detail)
  {
    $this->success = $success;
    $this->detail = $detail;
  }
}

$email = $_POST["inputEmail"] ?? '';
$senha = $_POST["inputSenha"] ?? '';

$pdo = mysqlConnect();
if ($hash_senha = checkPassword($pdo, $email, $senha)) {
  // Armazena dados úteis para confirmação 
  // de login em outros scripts PHP
  $_SESSION['emailUsuario'] = $email;
  $_SESSION['loginString'] = hash('sha512', $hash_senha . $_SERVER['HTTP_USER_AGENT']);  
  $response = new RequestResponse(true, '../php/restrita.php');
} 
else
  $response = new RequestResponse(false, ''); 

echo json_encode($response);

?>