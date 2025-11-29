<?php
include 'config/config.php';

// Consulta para pegar todos os clientes
$sql = "SELECT id, nome, email FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>

<h1>Lista de Clientes</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>
                <form action='deletar_cliente.php' method='POST'>
                    <input type='hidden' name='cliente_id' value='" . $row['id'] . "'>
                    <button type='submit'>Excluir</button>
                </form>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhum cliente cadastrado</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
