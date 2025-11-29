<?php
// Conexão com o banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "feedback";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Deleta o feedback
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Feedback deletado com sucesso.";
    } else {
        echo "Erro ao deletar o feedback: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();

// Redireciona de volta para a página de visualização dos feedbacks
header("Location: feedback.php");
exit();
?>
