<?php
require "../conexaoMysql.php";
$pdo = mysqlConnect();

try{
    $sql = <<<SQL
    SELECT codigo, titulo, descricao, preco

    FROM anuncio WHERE anuncio.codigo = 55

    
    SQL;
    // 1 seria o valor 'anunciante.codigo', aprendera em seção.

    // Neste exemplo não é necessário utilizar prepared statements
    // porque não há possibilidade de injeção de SQL, 
    // pois nenhum parâmetro é utilizado na query SQL
    $stmt = $pdo->query($sql);
}
catch (Exception $e) {
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
    <title>Home - Anunciante</title>
</head>

<body>
    <nav class="navbar">Feira.</nav>
    <main class="container container_n">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descrição</th>
                <th scope="col">Preço</th>
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
                while ($row = $stmt->fetch()){
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

                        </tr>  
                    HTML;
                }
            ?>
            </tbody>
          </table>
    </main>
    <footer></footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>