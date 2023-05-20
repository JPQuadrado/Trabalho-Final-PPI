<?php
require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

try {
  $sql = <<<SQL
    SELECT codigo, mensagem, data_hora, contato , cod_anuncio
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
      <a class="navbar-brand center" href="/home/index.php"><span id="emoji_solo_logo">&#129309; Feira.</span></a>
      <div class="d-flex gap-2 mb-3">
        <a href="/anuncio/cadastro/" class="btn btn-success">Novo Anuncio</a>
        <a href="/interesses/index.php" class="btn btn-secondary">Interesses</a>
        <a href="/" class="btn btn-outline-danger">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container container_n">
    <h1 class="text-center">Interesses</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Anuncio</th>
          <th scope="col">Mensagem</th>
          <th scope="col">Data</th>
          <th scope="col">Contato</th>
        </tr>
      </thead>
      <tbody>
        <!--
            <tbody>                
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
            -->
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

                            <td class="btn-container">

                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                              </button>       
                              <button class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                              </button>
                            </td>
                        </tr>

                    HTML;
        }
        ?>
      </tbody>
    </table>
  </main>

  <!-- Modal -->
  <div class="modal" id="confirmDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Clique em Confirmar para a remoção do comentario de interesse.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script>
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
      myInput.focus()
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>