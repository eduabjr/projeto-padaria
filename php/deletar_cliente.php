<?php
/**
 * Deletar Cliente
 * Arquivo consolidado para exclusão de clientes com segurança
 */
include 'config/config.php'; // Conexão com o banco

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Aceita tanto 'id' quanto 'cliente_id' para compatibilidade
    $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : (isset($_POST['id']) ? $_POST['id'] : null);

    // Verifica se o ID foi passado
    if (!empty($cliente_id)) {
        $sql = "DELETE FROM clientes WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cliente_id); // "i" indica que é um inteiro

        if ($stmt->execute()) {
            // Redireciona se veio de cadastro_cliente.php, senão mostra mensagem
            if (isset($_POST['redirect'])) {
                header("Location: " . $_POST['redirect']);
                exit();
            } else {
                header("Location: cadastro_cliente.php?msg=deleted");
                exit();
            }
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
?>
