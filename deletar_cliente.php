<?php
include 'config.php'; // Conexão com o banco

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente_id = $_POST['cliente_id'];

    // Verifica se o ID foi passado
    if (!empty($cliente_id)) {
        $sql = "DELETE FROM clientes WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cliente_id); // "i" indica que é um inteiro

        if ($stmt->execute()) {
            echo "Cliente excluído com sucesso!";
        } else {
            echo "Erro ao excluir cliente: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID do cliente não fornecido.";
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
