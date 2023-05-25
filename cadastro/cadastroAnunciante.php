<?php

class RequestResponse
{
    public $success;
    public $detail;

    function __construct($success, $detail)
    {
        $this->success = $success;
        $this->detail = $detail;
    }
}

require "../connect/conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";
$senha = $_POST["senha"] ?? "";

function insere($pdo, $nome, $cpf, $email, $telefone, $senha)
{
    $hashsenha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = <<<SQL
        INSERT INTO anunciante (nome, cpf, email, hash_senha, telefone)
        VALUES (?, ?, ?, ?, ?);
        SQL;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $email, $hashsenha, $telefone]);
    } catch (Exception $exception) {
        exit("Falha ao cadastrar os dados: " . $exception->getMessage());
    }
}

function campoInvalido($nome, $cpf, $email, $telefone, $senha)
{
    return empty($nome) || empty($cpf) || empty($email) || empty($telefone) || empty($senha);
}

if (campoInvalido($nome, $cpf, $email, $telefone, $senha)) {
    $response = new RequestResponse(false, 'Erro');
} else {
    insere($pdo, $nome, $cpf, $email, $telefone, $senha);
    $response = new RequestResponse(true, '../index.html');
}

header('Content-type: application/json');
echo json_encode($response);
