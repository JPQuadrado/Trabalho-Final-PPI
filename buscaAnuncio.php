<?php

require "connect/conexaoMysql.php";
$pdo = mysqlConnect();

class Anuncio{
  public $codigo;
  public $nome;
  public $descricao;
  public $preco;
  public $imagem;

  function __construct($codigo, $nome, $descricao, $preco, $imagem){
    $this->codigo = $codigo;
    $this->nome = $nome;
    $this->descricao = $descricao;
    $this->preco = $preco;
    $this->imagem = $imagem;
  }
}

try {
  $sqlFotos = <<<SQL
      SELECT nome_arquivo_foto
      FROM foto
      WHERE cod_anuncio = ?
      SQL;
    
  $sql = <<<SQL
      SELECT codigo, titulo, descricao, preco
      FROM anuncio
  SQL;

  $stmt = $pdo->query($sql);

  $anuncios = array();

  while($row = $stmt->fetch()){
    $codigo = $row["codigo"];
    $titulo = $row["titulo"];
    $descricao = $row["descricao"];
    $preco = $row["preco"];
  
    $stmtFotos = $pdo->prepare($sqlFotos);
    $stmtFotos->execute([$codigo]);
    $fotos = $stmtFotos->fetchAll(PDO::FETCH_COLUMN);
    $fotoInicial = $fotos[0];
    
    $anuncios[] = new Anuncio($codigo, $titulo, $descricao, $preco, "/anuncio/img/" . $fotoInicial);
  }

  header('Content-type: application/json');
  echo json_encode($anuncios);

} catch (Exception $exception) {
  exit("Falha: " . $exception->getMessage());
}