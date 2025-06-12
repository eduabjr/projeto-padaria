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

// Verifica se o ID foi passado e busca o feedback correspondente
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se encontrou um feedback
    if ($result->num_rows > 0) {
        $feedback = $result->fetch_assoc();
    } else {
        echo "Feedback não encontrado.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID do feedback não especificado.";
    exit;
}

// Processa o formulário de atualização se o método for POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback_text = $_POST['feedback'];
    $rating = $_POST['rating'];
    
    $sql = "UPDATE feedback SET name = ?, email = ?, feedback = ?, rating = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $feedback_text, $rating, $id);
    $stmt->execute();
    $stmt->close();
    
    echo "Feedback atualizado com sucesso!";
    header("Location: feedback.php");
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdf5e6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #b22222;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b22222;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #a00000;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Atualizar Feedback</h1>
    <form action="" method="post">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($feedback['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($feedback['email']); ?>" required>

        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" rows="6" required><?php echo htmlspecialchars($feedback['feedback']); ?></textarea>

        <label for="rating">Avaliação:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="<?php echo $feedback['rating']; ?>" required>

        <input type="submit" value="Atualizar Feedback">
    </form>
</div>

</body>
</html>