<?php

require "../../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? '';
$email = $_POST["email"] ?? '';
$cpf = $_POST["cpf"] ?? '';
$telefone = $_POST["telefone"] ?? '';
$senha_antiga = $_POST["senhaAntiga"] ?? '';
$senha_nova = $_POST["senhaNova"] ?? '';

function checkPass($pdo, $email, $senha){
    $sql = <<<SQL
        SELECT hash_senha
        FROM anunciante
        WHERE email = ?
        SQL;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        //  Declara em $row a tupla que foi identificada pela consulta
        $row = $stmt->fetch();
        //  Se a consulta não existir (email não existor), retorna false
        if (!$row) return false;

        return password_verify($senha, $row['hash_senha']);
    } 
    catch (Exception $e) {
        exit('Falha: ' . $e->getMessage());
    }
}

if (checkPass($pdo, $email, $senha_antiga)){

    $sqlUpdate = <<<SQL
        UPDATE anunciante
        SET nome = ?, cpf = ?, hash_senha = ?, telefone = ?
        where email = ?
        SQL;

        $hash_senha = password_hash($senha_nova, PASSWORD_DEFAULT);

        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nome, $cpf, $hash_senha, $telefone, $email]);
    header(http_response_code(200));
}
else{
    header(http_response_code(400));
}

?>