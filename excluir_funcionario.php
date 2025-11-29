<?php
include 'config2.php'; // Arquivo com a conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Recebe o ID do funcionário a ser excluído

    // Query para deletar o funcionário
    $sql = "DELETE FROM funcionarios WHERE codigo = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Funcionário excluído com sucesso!'); window.location.href = '1.php';</script>";
    } else {
        echo "Erro ao excluir funcionário: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
