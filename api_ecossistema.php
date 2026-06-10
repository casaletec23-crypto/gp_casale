<?php
// C:\xampp\htdocs\GPCasale\api_ecossistema.php

header("Content-Type: application/json");
require_once "conexao.php";

$metodo = $_SERVER['REQUEST_METHOD'];
$modulo = $_GET['modulo'] ?? '';

// Lista de tabelas permitidas para segurança contra SQL Injection
$tabelas_permitidas = ['vendas', 'gastos', 'pessoal', 'reservas', 'estoque', 'caixinhas'];

// ═════════════════════════════════════════════════════════════════════════
// ─── [READ] OPERAÇÃO DE LEITURA (GET)
// ═════════════════════════════════════════════════════════════════════════
if ($metodo === 'GET') {
    try {
        if ($modulo === 'tudo') {
            // Traz todas as tabelas de uma vez só para alimentar o Dashboard instantaneamente
            echo json_encode([
                "vendas"    => $pdo->query("SELECT * FROM vendas ORDER BY data DESC, hora DESC")->fetchAll(PDO::FETCH_ASSOC),
                "gastos"    => $pdo->query("SELECT * FROM gastos ORDER BY data DESC")->fetchAll(PDO::FETCH_ASSOC),
                "pessoal"   => $pdo->query("SELECT * FROM pessoal ORDER BY data DESC")->fetchAll(PDO::FETCH_ASSOC),
                "reservas"  => $pdo->query("SELECT * FROM reservas ORDER BY data ASC, hora ASC")->fetchAll(PDO::FETCH_ASSOC),
                "estoque"   => $pdo->query("SELECT * FROM estoque ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC),
                "caixinhas" => $pdo->query("SELECT * FROM caixinhas ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC)
            ]);
        } elseif (in_array($modulo, $tabelas_permitidas)) {
            $stmt = $pdo->query("SELECT * FROM $modulo");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(["erro" => "Módulo inválido."]);
        }
    } catch (Exception $e) {
        echo json_encode(["erro" => $e->getMessage()]);
    }
    exit;
}

// ═════════════════════════════════════════════════════════════════════════
// ─── [CREATE / UPDATE] OPERAÇÃO DE INSERÇÃO E ATUALIZAÇÃO (POST)
// ═════════════════════════════════════════════════════════════════════════
if ($metodo === 'POST') {
    if (!in_array($modulo, $tabelas_permitidas)) {
        echo json_encode(["sucesso" => false, "erro" => "Módulo inválido."]);
        exit;
    }

    // Captura o JSON enviado pelo JavaScript
    $dados = json_decode(file_get_contents("php://input"), true);

    try {
        // Se houver um ID numérico enviado, o PHP entende que é uma ATUALIZAÇÃO (UPDATE)
        $isUpdate = !empty($dados['id']) && is_numeric($dados['id']); 

        if ($isUpdate) {
            switch ($modulo) {
                case 'vendas':
                    $sql = "UPDATE vendas SET status = :status WHERE id = :id";
                    break;
                case 'estoque':
                    $sql = "UPDATE estoque SET qtd = :qtd WHERE id = :id";
                    break;
                case 'caixinhas':
                    $sql = "UPDATE caixinhas SET saldo = :saldo WHERE id = :id";
                    break;
                default:
                    echo json_encode(["sucesso" => false, "erro" => "Update não suportado para este módulo."]);
                    exit;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);
        } else {
            // Se NÃO houver ID, o PHP entende que é um REGISTRO NOVO (CREATE / INSERT)
            switch ($modulo) {
                case 'vendas':
                    $sql = "INSERT INTO vendas (data, hora, cliente, produto, quantidade, valor, total, status) VALUES (:data, :hora, :cliente, :produto, :quantidade, :valor, :total, :status)";
                    break;
                case 'gastos':
                    $sql = "INSERT INTO gastos (data, descricao, categoria, valor) VALUES (:data, :descricao, :categoria, :valor)";
                    break;
                case 'pessoal':
                    $sql = "INSERT INTO pessoal (data, nome, descricao, valor) VALUES (:data, :nome, :descricao, :valor)";
                    break;
                case 'reservas':
                    $sql = "INSERT INTO reservas (data, cliente, servico, hora, obs, status) VALUES (:data, :cliente, :servico, :hora, :obs, :status)";
                    break;
                case 'estoque':
                    $sql = "INSERT INTO estoque (nome, categoria, qtd, min, val) VALUES (:nome, :categoria, :qtd, :min, :val)";
                    break;
                case 'caixinhas':
                    $sql = "INSERT INTO caixinhas (nome, meta, saldo) VALUES (:nome, :meta, :saldo)";
                    break;
            }
            
            // Remove o ID temporário do JS se existir, deixando o MySQL gerar o ID automático
            if (isset($dados['id'])) unset($dados['id']);
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);
        }

        echo json_encode(["sucesso" => true]);
    } catch (Exception $e) {
        echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
    }
    exit;
}

// ═════════════════════════════════════════════════════════════════════════
// ─── [DELETE] OPERAÇÃO DE EXCLUSÃO (DELETE)
// ═════════════════════════════════════════════════════════════════════════
if ($metodo === 'DELETE') {
    if (!in_array($modulo, $tabelas_permitidas)) {
        echo json_encode(["sucesso" => false, "erro" => "Módulo inválido."]);
        exit;
    }

    $dados = json_decode(file_get_contents("php://input"), true);

    if (!empty($dados['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM $modulo WHERE id = :id");
            $stmt->execute([':id' => $dados['id']]);
            echo json_encode(["sucesso" => true]);
        } catch (Exception $e) {
            echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "ID inválido ou em falta."]);
    }
    exit;
}
?>