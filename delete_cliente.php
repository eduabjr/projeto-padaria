<?php
include 'config.php';

$id = $_POST['id'];

$sql = "DELETE FROM clientes WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: cadastro_cliente.php");
    exit();
} else {
    echo "Erro ao excluir cliente: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
