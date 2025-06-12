<?php
include 'config2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    // Adicione os outros campos aqui...

    // Consulta SQL para atualizar o funcionário
    $sql = "UPDATE funcionarios SET 
                nome = '$nome',
                sexo = '$sexo',
                email = '$email'
                WHERE codigo = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Funcionário atualizado com sucesso!'); window.location.href = '1.php';</script>";
    } else {
        echo "Erro ao atualizar funcionário: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
