<?php
// C:\xampp\htdocs\GPCasale\conexao.php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "gp_casale";

try {
    // Conecta ao MySQL definindo o charset para UTF-8 (evita bugs com acentos e ç)
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["erro" => "Falha ao ligar ao banco de dados: " . $e->getMessage()]);
    exit;
}
?>
