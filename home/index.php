<?php

require "../connect/conexaoMysql.php";
require "../sessionVerification.php";

session_start();
exitWhenNotLoggedIn();

$pdo = mysqlConnect();

$codAnunciante = $_SESSION["codAnunciante"];

try {
  $sql = <<<SQL
    SELECT codigo, titulo, descricao, preco
    FROM anuncio WHERE cod_anunciante = $codAnunciante
    SQL;

  // Neste exemplo não é necessário utilizar prepared statements
  // porque não há possibilidade de injeção de SQL, 
  // pois nenhum parâmetro é utilizado na query SQL
  $stmt = $pdo->query($sql);
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Home - Anunciante</title>
</head>

<body>
  <header>
    <nav class="navbar sticky-top navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand center" href="/"><span id="emoji_solo_logo">&#129309; Feira.</span></a>
        <div class="gap-2 mb-2">
          <a href="/anuncio/cadastro/" class="btn btn-outline-light btnNav">Novo Anuncio</a>
          <a href="/interesses/" class="btn btn-outline-light btnNav">Interesses</a>
          <a href="/conta/atualizar/" class="btn btn-outline-light btnNav">Atualizar dados</a>
          <a href="/logout.php" class="btn btn-outline-light btnNav">Logout</a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container container_n ">
    <h1 id="title-home">Anuncios</h1>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Titulo</th>
            <th scope="col">Descrição</th>
            <th scope="col">Preço</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $stmt->fetch()) {
            // Limpa os dados produzidos pelo usuário
            // com possibilidade de ataque XSS
            $codigo = htmlspecialchars($row['codigo']);
            $titulo = htmlspecialchars($row['titulo']);
            $descricao = htmlspecialchars($row['descricao']);
            $preco = htmlspecialchars($row['preco']);

            echo <<<HTML
                <tr>

                    <th scope="row">$codigo</th>
                    <td>$titulo</td>
                    <td>$descricao</td> 
                    <td>$preco</td>

                    <td>
                      <a type="button" href="/anuncio/index.php?cod=$codigo" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                          <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                          <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                      </a>

                      <a type="button" class="btn btn-danger" href="exclui-anuncio.php?codigo=$codigo" id="confirm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                      </a>
                    </td>
                </tr>
            HTML;
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>