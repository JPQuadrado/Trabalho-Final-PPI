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
  $anuncios = array();

  $sqlFotos = <<<SQL
      SELECT nome_arquivo_foto
      FROM foto
      WHERE cod_anuncio = ?
      SQL;
    
  $sqlAnuncio = <<<SQL
      SELECT codigo, titulo, descricao, preco
      FROM anuncio
  SQL;

  $stmtAnuncio = $pdo->query($sqlAnuncio);

  /**
   * Percorre todas as linhas, uma por uma e atribui valores as variáveis.
   * Para cada linha, é feito uma query na tabela de nome de fotos. Pega o array de fotos
   * respectivo ao anuncio e pega a primeira ocorrencia do array (será a primeira foto).
   * 
   * Por fim, adiciona ao vetor $anuncios, um objeto respectivo contendo as informações.
   */
  while($row = $stmtAnuncio->fetch()){
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

  header("Content-type: application/json");
  echo json_encode($anuncios);
}
catch (Exception $exception) {
  exit("Falha: " . $exception->getMessage());
}