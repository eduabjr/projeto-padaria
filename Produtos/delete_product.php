<?php
include '../config/configuration.php';

// Verifica se o ID foi enviado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta SQL para excluir o produto
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Executa a consulta e verifica se foi bem-sucedido
    if ($stmt->execute()) {
        echo "Produto deletado com sucesso!";
    } else {
        echo "Erro ao deletar produto.";
    }
} else {
    echo "ID do produto não fornecido.";
}
?>
