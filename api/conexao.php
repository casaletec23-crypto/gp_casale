<?php
// api/conexao.php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "gp_casale";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["erro" => "Falha ao ligar ao banco de dados: " . $e->getMessage()]);
    exit;
}
?>
