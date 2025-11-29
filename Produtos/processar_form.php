<?php
include '../config/configuration.php';  // Inclui a conexão PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    // Usando PDO para preparar a consulta
    $stmt = $pdo->prepare("INSERT INTO produtos (id, nome) VALUES (?, ?)");
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $nome);
    
    if ($stmt->execute()) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto.";
    }
}
?>
