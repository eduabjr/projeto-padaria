<?php
// Conectar ao banco de dados usando configuração unificada
require_once 'config/config_db.php';
$conn = getMySQLiConnection(DB_FEEDBACK);

// Verifica a conexão
if (!$conn) {
    die("Falha na conexão com o banco de dados");
}

// Receber dados do formulário
$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];
$rating = $_POST['rating'];

// Inserir dados no banco de dados
$sql = "INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $name, $email, $feedback, $rating);

if ($stmt->execute()) {
    // Redireciona de volta para feedback.php sem mostrar nada
    header('Location: feedback.php?success=1');
    exit();
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
