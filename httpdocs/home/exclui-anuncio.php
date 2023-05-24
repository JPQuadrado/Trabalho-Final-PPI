<?php
require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

$codigo = $_GET["codigo"] ?? "";

try {
    $sql = <<<SQL
        DELETE FROM anuncio
        WHERE codigo = ?
        LIMIT 1      
    SQL;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo]);

    header("location: index.php");
    exit();
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}
