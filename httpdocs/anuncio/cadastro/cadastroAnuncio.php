<?php

require "../../conexaoMysql.php";
$pdo = mysqlConnect();

$titulo = $_POST["titulo"] ?? '';
$preco = $_POST["preco"] ?? '';
$descricao = $_POST["descricao"] ?? '';
$cep = $_POST["cep"] ?? '';
$datahora = $_POST["datahora"] ?? '';
$foto = $_POST["foto"] ?? '';
$categoria = $_POST["categoria"] ?? '';
$bairro = $_POST["bairro"] ?? '';
$cidade = $_POST["cidade"] ?? '';
$estado = $_POST["estado"] ?? '';

$sqlAnuncio = <<<SQL
    INSERT INTO anuncio (cod_categoria, cod_anunciante, titulo, descricao, preco, data_hora, cep, bairro, cidade, estado)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
    SQL;

$sqlFoto = <<<SQL
    INSERT INTO foto (codAnuncio, nome_arquivo_foto)
    VALUES (?, ?);
    SQL;

$sqlCategoria = <<<SQL
    SELECT codigo 
    FROM categoria
    WHERE categoria.codigo = ?
    SQL;

try{
    $pdo->beginTransaction();

    $ultimoIdInserido = $pdo->lastInsertId();

    $stmtCategoria = $pdo->prepare($sqlCategoria);
    $stmtCategoria->execute([$categoria]);

    $stmtAnuncio = $pdo->prepare($sqlAnuncio);
    if (!$stmtAnuncio->execute([$stmtCategoria, $stmtAnunciante, $titulo, $descricao, $preco, $datahora, $cep, $bairro, $cidade, $estado])){
        throw new Exception('Falha na operação de inserção do anuncio');
    }

    $stmtFoto = $pdo->prepare($sqlFoto);
    if (!$stmtFoto->execute([$ultimoIdInserido, $foto])){
        throw new Exception('Falha na operação de inserção do foto do anuncio');
    }
    
    $pdo->commit();
}
catch(Exception $e){
    $pdo->rollBack();
    exit('Falha na transação: ' . $e->getMessage());
}
?>