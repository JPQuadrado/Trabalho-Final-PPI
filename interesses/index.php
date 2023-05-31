<?php
require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

require "../sessionVerification.php";

session_start();
exitWhenNotLoggedIn();

$codAnunciante = $_SESSION["codAnunciante"];

try {
  $sql = <<<SQL
    SELECT codigo, mensagem, data_hora, contato , cod_anuncio
    FROM interesse
    WHERE cod_anuncio IN (SELECT codigo FROM anuncio WHERE cod_anunciante = $codAnunciante)
    ORDER BY data_hora asc;
    
    SQL;

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
  <nav class="navbar sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand center" href="/"><span id="emoji_solo_logo">&#129309; Feira.</span></a>
      <div class="gap-2 mb-2">
        <a href="/home/" class="btn btn-outline-light btnNav">Home</a>
        <a href="/anuncio/cadastro/" class="btn btn-outline-light btnNav">Novo Anuncio</a>
        <a href="/conta/atualizar/" class="btn btn-outline-light btnNav">Atualizar dados</a>
        <a href="/logout.php" class="btn btn-outline-light btnNav">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container">
    <h1 id="title-interesse">Interesses</h1>
    <table class="table table-hover table-responsive">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Anuncio</th>
          <th scope="col">Mensagem</th>
          <th scope="col">Data</th>
          <th scope="col">Contato</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $stmt->fetch()) {
          // Limpa os dados produzidos pelo usuário
          // com possibilidade de ataque XSS
          $codigo = htmlspecialchars($row['codigo']);
          $cod_anuncio = htmlspecialchars($row['cod_anuncio']);
          $mensagem  = htmlspecialchars($row['mensagem']);
          $data_hora  = htmlspecialchars($row['data_hora']);
          $contato = htmlspecialchars($row['contato']);

          echo <<<HTML
            <tr>

                <th scope="row">$codigo</th>
                <td>$cod_anuncio</td>
                <td>$mensagem</td>
                <td>$data_hora</td> 
                <td>$contato</td>

                <td>   
                  <a type="button" class="btn btn-primary" href="mailto:$contato">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                      <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                      <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                    </svg>
                  </a>
                  <a type="button" class="btn btn-danger" href="exclui-interesse.php?codigo=$codigo">
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
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>