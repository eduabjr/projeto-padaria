<?php
// Conectar ao banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "feedback";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar os feedbacks
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

echo "<table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Feedback</th>
            <th>Avaliação</th>
            <th>Ações</th>
        </tr>";

// Exibe cada linha de feedback
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
echo "</table>";

$conn->close();
?>
