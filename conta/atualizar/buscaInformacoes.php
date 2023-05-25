<?php

require "../../connect/conexaoMysql.php";
$pdo = mysqlConnect();
$email = $_GET["email"];

try {
    $sql = <<<SQL
        SELECT nome, cpf, email, telefone
        FROM anunciante
        WHERE email = $email;
    SQL;

    $stmt = $pdo->query($sql);
    $informacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($informacoes);
} catch (Exception $exception) {
    exit("Falha: " . $exception->getMessage());
}
