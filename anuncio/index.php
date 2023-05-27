<?php

require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

$codAnuncio = $_GET["cod"];

function verifyAnuncio($pdo, $codAnuncio){
    $sql = <<<SQL
        SELECT codigo
        FROM anuncio
        WHERE codigo = ?
        SQL;

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codAnuncio]);

        return $stmt->rowCount() > 0;
    }
    catch(Exception $e){
        exit("Erro: " . $e->getMessage());
    }
}

if(!verifyAnuncio($pdo, $codAnuncio)){
    header("Location: /");
    exit();
}
else{

    $sql = <<<SQL
        SELECT *
        FROM anuncio
        WHERE codigo = ?
        SQL;

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codAnuncio]);
    }
    catch(Exception $e){
        exit("Erro: " . $e->getMessage());
    }

    while ($row = $stmt->fetch()) {
        $titulo = htmlspecialchars($row['titulo']);
        $descricao = htmlspecialchars($row['descricao']);
        $preco = htmlspecialchars($row['preco']);
    }
    
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>Anuncio detalhado</title>
        </head>
        <body>
            <header>
                <nav id="menu-nav">
                    <span id="emoji">&#129309; Feira.</span>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/conta/cadastro/">Cadastro</a></li>
                        <li><a href="/conta/login/">Login</a></li>
                    </ul>
                </nav>
            </header>

            <main>
                <div class="div-anuncio-detalhado">
                    <div class="div-anuncio-detalhado-foto">
                        <img src="img/caneca1.jpg" class="img-div-anuncio" alt="Caneca personalizada">
                        <button class="btn-div-anuncio">Proxima foto</button>
                    </div>
                    <div class="div-anuncio-detalhado-informacoes">
                        <h1>$titulo</h1>
                        <p>$descricao</p>
                        <p>Preço: $preco</p>
                    </div>
                </div>

                <div class="interesse">
                    <h1>Mensagem de interesse</h1>
                    <div>
                        <form action="cadastroInteresse.php" method="post" class="interesse-form">
                            <div>
                                <label for="mensagem">Mensagem</label>
                                <input type="text" name="mensagem" id="mensagem">
                            </div>
                            <div>
                                <label for="contato">Email para contato</label>
                                <input type="email" name="contato" id="contato">
                            </div>

                            <button type="submit" id="btn-enviar">Enviar mensagem</button>
                        </form>
                    </div>
                </div>
            </main>

            <script src="js/script.js"></script>
        </body>
    </html>
    HTML;
}

?>