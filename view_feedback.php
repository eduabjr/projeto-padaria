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

// Consulta para buscar os feedbacks
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks - Padaria Clementino</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #b22222;
            color: #fff;
        }
        .btn {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-delete {
            background-color: #b22222;
        }
        .btn-update {
            background-color: #ffa500;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Feedbacks Recebidos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Feedback</th>
            <th>Avaliação</th>
            <th>Ações</th>
        </tr>
        <?php
        // Exibe cada linha de feedback
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["feedback"] . "</td>
                    <td>" . $row["rating"] . "</td>
                    <td>
                        <a href='update_feedback.php?id=" . $row["id"] . "' class='btn btn-update'>Atualizar</a>
                        <a href='delete_feedback.php?id=" . $row["id"] . "' class='btn btn-delete' onclick=\"return confirm('Tem certeza que deseja deletar este feedback?');\">Deletar</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum feedback encontrado.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
