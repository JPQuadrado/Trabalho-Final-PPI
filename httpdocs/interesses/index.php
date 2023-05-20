<?php
require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

try {
  $sql = <<<SQL
    SELECT codigo, mensagem, data_hora, contato
    FROM interesse
    WHERE cod_anuncio IN (SELECT codigo FROM anuncio WHERE cod_anunciante = 1);
    
    SQL;
  // 55 seria o valor 'anunciante.codigo', aprendera em seção.

  // Neste exemplo não é necessário utilizar prepared statements
  // porque não há possibilidade de injeção de SQL, 
  // pois nenhum parâmetro é utilizado na query SQL
  $stmt = $pdo->query($sql);
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Home - Interesses</title>
</head>

<body>
  <nav class="navbar">
    <div class="container-fluid">
      <a class="navbar-brand center" href="#"><span id="emoji_solo_logo">&#129309; Feira.</span></a>
      <div class="d-flex gap-2 mb-3">
        <a href="/anuncio/cadastro/" class="btn btn-success">Novo Anuncio</a>
        <a href="/anuncio/interesse/index.php" class="btn btn-secondary">Interesses</a>
        <a href="/" class="btn btn-outline-danger">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container container_n">
    <h1 class="text-center">Interesses</h1>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>