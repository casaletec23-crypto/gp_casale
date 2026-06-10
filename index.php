<?php
// index.php
// Este ficheiro é o ponto de entrada. Ele não contém lógica pesada, 
// apenas monta a estrutura chamando os blocos (views) necessários.
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>GP Casale | Gestão</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <?php include 'views/nav.php'; ?>

    <main>
        <?php 
            // Cada "view" é um bloco HTML independente.
            // Se precisar de editar as Vendas, vai a views/vendas.php
            include 'views/resumo.php';
            include 'views/vendas.php';
            include 'views/gastos.php';
            include 'views/pessoal.php';
            include 'views/estoque.php';
            include 'views/caixinhas.php';
            include 'views/historico.php';
            include 'views/reservas.php';
        ?>
    </main>

    <script src="assets/js/app.js"></script>
</body>
</html>
