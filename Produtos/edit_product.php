<?php
include '../config/configuration.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta para buscar os dados do produto
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Verifica se o produto foi encontrado
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        echo json_encode($product);  // Retorna os dados do produto em JSON
    } else {
        echo json_encode(['error' => 'Produto não encontrado.']);
    }
}
?>
