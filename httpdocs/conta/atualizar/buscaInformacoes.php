<?php

require "../conections/conexaoMysql.php";
$pdo = mysqlConnect();

try {
    $sql = <<<SQL
        SELECT nome, cpf, email, telefone
        FROM anunciante
        WHERE codigo = 22;
    SQL;

    $stmt = $pdo->query($sql);
    $informacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($informacoes);
} catch (Exception $exception) {
    exit("Falha: " . $exception->getMessage());
}
