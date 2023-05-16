<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";
$senha = $_POST["senha"] ?? "";

$hashsenha = password_hash($senha, PASSWORD_DEFAULT);

$sql = <<<SQL
    INSERT INTO anunciante (nome, cpf, email, hash_senha, telefone)
    VALUES (?, ?, ?, ?, ?);
    SQL;
    
try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $cpf, $email, $hashsenha, $telefone]);

    header("location: ../");
    exit();
}
catch (Exception $exception){
    exit("Falha ao cadastrar os dados: " . $exception->getMessage());
}